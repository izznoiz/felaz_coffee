<?php

namespace App\Http\Controllers;

use App\Models\OrdersBatch;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = OrdersBatch::with('user')->latest();

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $batches = $query->paginate(10);

        return view('admin.orders.index', compact('batches'));
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

    public function export(Request $request)
    {
        $query = OrdersBatch::with(['user', 'orders.product'])->latest();

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $batches = $query->get();

        $pdf = Pdf::loadView('admin.orders.export', compact('batches'));

        return $pdf->download('laporan-pesanan.pdf');
    }
}
