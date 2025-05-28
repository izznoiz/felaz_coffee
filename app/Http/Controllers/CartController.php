<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Produk;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrdersBatch;
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
        $cartItems = CartItem::where('user_id', auth()->id())->get();
        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang kosong.');
        }
        $totalPriceBatch = 0;
        foreach ($cartItems as $item) {
            $totalPriceBatch = $totalPriceBatch + ($item->product->harga * $item->quantity);
        }
        $orderBatch = OrdersBatch::create([
            'user_id' => auth()->id(),
            'total_price' => $totalPriceBatch,
            'status' => 'pending',
            'user_name' => auth()->id()
        ]);

        // Get the ID of the created order batch
        $orderBatchId = $orderBatch->id;

        foreach ($cartItems as $item) {
            $totalPrice = $item->product->harga * $item->quantity;
            $order = Order::create([
                'order_batch_id' => $orderBatchId,
                'user_id' => auth()->id(),
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'total_price' => $totalPrice,
                'status' => 'pending'
            ]);
        }

        // Kosongkan keranjang
        CartItem::where('user_id', auth()->id())->delete();

        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dibuat!');
    }
}
