<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AdminOrderController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\XenditController;
use App\Http\Controllers\GuestController;


// Routes untuk Guest (tidak perlu login)
Route::get('/', [GuestController::class, 'index'])->name('guest.index');
Route::get('/product/{id}', [GuestController::class, 'showProduct'])->name('guest.product');


// Default: Arahkan root '/' ke halaman login Jetstream
// Route::get('/', function () {
//     Route::get('/', [GuestController::class, 'index'])->name('guest.index');
//     // return redirect()->route('login');
// });

// Hanya izinkan akses ke semua route ini jika sudah login & verifikasi
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {



    // === Admin ===
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/produk/create', [ProdukController::class, 'create'])->name('produk.create');
        Route::get('/admin/produk', [ProdukController::class, 'index'])->name('admin.produk.index');
        Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
        Route::get('/admin/produk/{produk}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
        Route::put('/produk/{produk}', [ProdukController::class, 'update'])->name('produk.update');
        Route::delete('/produk/{produk}', [ProdukController::class, 'destroy'])->name('produk.destroy');
        Route::get('/admin/produk/{produk}', [ProdukController::class, 'show'])->name('produk.show');

        // Orders admin routes 👇
        Route::get('/admin/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
        Route::get('/admin/orders/export', [AdminOrderController::class, 'export'])->name('admin.orders.export');
        Route::get('/admin/orders/{id}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
        Route::patch('/admin/orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
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
        Route::get('/checkout/success', [CartController::class, 'checkoutSuccess'])->name('checkout.success');
        Route::get('/checkout/success', [CartController::class, 'handlePaymentSuccess'])->name('checkout.success');
        Route::get('/checkout/failed', function () {
            return view('checkout.failed');
        })->name('return.checkout');
        Route::post('/xendit/webhook', [XenditController::class, 'handleWebhook']);
    });

    Route::get('/dashboard', function () {
        if (Auth::user()->hasRole(roles: 'admin')) {
            return redirect()->route('admin.produk.index');
        } else {
            return redirect()->route('produk.index');
        }
    })->name('dashboard');



    Route::post('/chatbot', [ChatbotController::class, 'handle']);
});
