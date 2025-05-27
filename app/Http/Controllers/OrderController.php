<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class OrderController extends Controller
{
    public function store(Request $request, Produk $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);
        $productId = $product->id;
        $quantity = $request->quantity;
        $totalPrice = $product->harga * $request->quantity;
        Order::create([
            'user_id' => Auth::id(),
            'product_id' => $productId,
            'quantity' => $quantity,
            'total_price' => $totalPrice,
            'status' => 'pending'
        ]);

        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dibuat! Silakan cek daftar pesanan Anda.');
    }

    public function index()
    {
        $orders = Order::with('product')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10); // 10 orders per page

        return view('orders.index', compact('orders'));
    }
}
