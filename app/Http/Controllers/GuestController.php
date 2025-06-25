<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    /**
     * Display the guest homepage with products
     */
    public function index()
    {
        // Mengambil semua produk atau bisa juga dibatasi
        $produks = Produk::latest()->get();
        
        return view('guest.index', compact('produks'));
    }

    /**
     * Show product detail for guests (redirect to login)
     */
    public function showProduct($id)
    {
        // Redirect ke login dengan parameter intended untuk kembali ke produk
        return redirect()->route('login')->with('intended', route('guest.product', $id));
    }
}