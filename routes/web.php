<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Auth;



// Default: Arahkan root '/' ke halaman login Jetstream
Route::get('/', function () {
    return redirect()->route('login');
});

// Hanya izinkan akses ke semua route ini jika sudah login & verifikasi
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // Route::get('/produk/{produk}', [ProdukController::class, 'show'])->name('produk.show');
    // === Admin ===
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/produk/create', [ProdukController::class, 'create'])->name('produk.create');
        Route::get('/admin/produk', [ProdukController::class, 'index'])->name('admin.produk.index');
        Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
        Route::get('/admin/produk/{produk}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
        Route::put('/produk/{produk}', [ProdukController::class, 'update'])->name('produk.update');
        Route::delete('/produk/{produk}', [ProdukController::class, 'destroy'])->name('produk.destroy');
        Route::get('/admin/produk/{produk}', [ProdukController::class, 'show'])->name('produk.show');
    });

    // === Pelanggan ===
    Route::middleware('role:pelanggan')->group(function () {
        Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
        Route::get('/produk/{produk}', [ProdukController::class, 'show'])->name('produk.show');

        // Order routes
        Route::post('/produk/{product}/order', [OrderController::class, 'store'])->name('orders.store');
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

        // === Cart routes === //
        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
        Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
        Route::delete('/cart/remove/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');
        Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
        Route::get('cart/orders', [CartController::class, 'index'])->name('orders.index');
    });



    // // Untuk admin
    // Route::middleware(['auth', 'role:admin'])->group(function () {
    //     Route::resource('produk', ProdukController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);
    // });

    // // Untuk semua user (termasuk pelanggan)
    // Route::middleware(['auth', 'role:pelanggan'])->group(function () {
    //     Route::resource('produk', ProdukController::class)->only(['index', 'show']);
    //     Route::post('/products/{product}/order', [OrderController::class, 'store'])->name('orders.store');
    //     Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    // });



    // Route::middleware(['auth', new RoleMiddleware('admin')])->group(function () {
    //     Route::get('/produk/create', [ProdukController::class, 'create'])->name('produk.create');
    //     Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
    // });

    // Route::middleware(['auth', new RoleMiddleware('pelanggan')])->group(function () {
    //     Route::get('/pesan', [PesananController::class, 'index'])->name('pesan.index');
    // });


    // Ubah dashboard ke produk
    // Route::get('/dashboard', function () {
    //     return redirect()->route('admin.produk.index');
    // })->name('dashboard');

    Route::get('/dashboard', function () {
        if (Auth::user()->hasRole(roles: 'admin')) {
            return redirect()->route('admin.produk.index');
        } else {
            return redirect()->route('produk.index');
        }
    })->name('dashboard');


    // Semua route produk (index, create, store, show, edit, update, destroy)
    // Route::resource('produk', ProdukController::class);
});
