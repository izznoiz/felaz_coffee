<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Produk;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrdersBatch;
use App\Events\NewOrderPlaced;
use Xendit\Xendit;
// use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function add(Request $request, Produk $product)
    {
        $cartItem = CartItem::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            CartItem::create([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'quantity' => $request->quantity
            ]);
        }

        if ($request->ajax()) {
            return response()->json(['message' => 'Produk ditambahkan ke keranjang']);
        }

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function index()
    {
        $cartItems = CartItem::with('product')->where('user_id', auth()->id())->get();
        $total = $cartItems->sum(fn($item) => $item->product->harga * $item->quantity);

        return view('cart.index', compact('cartItems', 'total'));
    }
    public function remove(CartItem $cartItem)
    {
        // Cek kepemilikan
        if ($cartItem->user_id !== auth()->id()) {
            abort(403);
        }

        $cartItem->delete();
        return back()->with('success', 'Produk dihapus dari keranjang.');
    }

    public function checkout(Request $request)
    {
        $cartItems = CartItem::where('user_id', auth()->id())->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang kosong.');
        }

        $user = auth()->user();
        $totalPrice = $cartItems->sum(fn($item) => $item->product->harga * $item->quantity);

        // Generate external ID
        $externalId = 'order-' . uniqid();

        // (Opsional) Simpan snapshot cart + external_id ke tabel `pending_checkouts`
        DB::table('pending_checkouts')->insert([
            'external_id' => $externalId,
            'user_id' => $user->id,
            'cart_snapshot' => json_encode($cartItems),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Buat invoice di Xendit
        $response = Http::withBasicAuth(env('XENDIT_API_KEY'), '')
            ->post('https://api.xendit.co/v2/invoices', [
                'external_id' => $externalId,
                'amount' => $totalPrice,
                'payer_email' => $user->email,
                'description' => 'Pembayaran Pesanan Kopi Online',
                'success_redirect_url' => route('checkout.success', ['external_id' => $externalId]),
                'failure_redirect_url' => route('return.checkout'),
            ]);

        if ($response->successful()) {
            return redirect($response['invoice_url']);
        } else {
            return back()->with('error', 'Gagal membuat invoice. Coba lagi.');
        }
    }

    public function handlePaymentSuccess(Request $request)
    {
        $externalId = $request->get('external_id');

        // Ambil data dari pending_checkouts
        $pending = DB::table('pending_checkouts')->where('external_id', $externalId)->first();

        if (!$pending) {
            return redirect()->route('orders.index')->with('error', 'Pembayaran tidak valid atau sudah diproses.');
        }

        $cartItems = json_decode($pending->cart_snapshot);

        $totalPriceBatch = array_reduce($cartItems, function ($carry, $item) {
            return $carry + ($item->product->harga * $item->quantity);
        }, 0);

        // Simpan OrdersBatch
        $orderBatch = OrdersBatch::create([
            'user_id' => $pending->user_id,
            'total_price' => $totalPriceBatch,
            'status' => 'pending',
            'user_name' => $pending->user_id, 
        ]);

        foreach ($cartItems as $item) {
            Order::create([
                'order_batch_id' => $orderBatch->id,
                'user_id' => $pending->user_id,
                'product_id' => $item->product->id,
                'quantity' => $item->quantity,
                'total_price' => $item->product->harga * $item->quantity,
                'status' => 'pending',
            ]);
        }


          // PENTING: Load relasi sebelum broadcast
        $orderBatch = $orderBatch->fresh(['user', 'orders.product']);
        
        // Debug: Cek apakah relasi sudah ter-load
        \Log::info('OrderBatch data for broadcast:', [
            'id' => $orderBatch->id,
            'user' => $orderBatch->user ? $orderBatch->user->name : 'No user',
            'orders_count' => $orderBatch->orders->count(),
            'first_product' => $orderBatch->orders->first() ? $orderBatch->orders->first()->product->nama ?? 'No product name' : 'No orders'
        ]);
        
        broadcast(new NewOrderPlaced($orderBatch));

        // Kosongkan keranjang & pending_checkouts
        CartItem::where('user_id', $pending->user_id)->delete();
        DB::table('pending_checkouts')->where('external_id', $externalId)->delete();

        return redirect()->route('orders.index')->with('success', 'Pembayaran berhasil! Pesananmu sudah masuk.');
    }
}