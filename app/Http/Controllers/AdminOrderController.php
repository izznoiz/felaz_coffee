<?php

namespace App\Http\Controllers;

use App\Models\OrdersBatch;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index()
    {
        $batches = OrdersBatch::with('orders.product', 'user')->latest()->paginate(10);
        return view('admin.orders.index', compact('batches'));
    }

    public function show($id)
    {
        $batch = OrdersBatch::with('orders.product', 'user')->findOrFail($id);
        return view('admin.orders.show', compact('batch'));
        
    }

    public function updateStatus(Request $request, OrdersBatch $batch)
    {
        $request->validate(['status' => 'required|string']);
        $batch->update(['status' => $request->status]);

        return back()->with('success', 'Status pesanan diperbarui.');
    }
}
