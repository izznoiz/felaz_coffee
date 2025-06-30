<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AdminOrderController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\XenditController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\EmailVerificationNotificationController;



// Routes untuk Guest (tidak perlu login)
Route::get('/', [GuestController::class, 'index'])->name('guest.index');
Route::get('/product/{id}', [GuestController::class, 'showProduct'])->name('guest.product');

// Route untuk menampilkan halaman verify email
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// Route untuk memproses link verifikasi
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');


// Hanya izinkan akses ke semua route ini jika sudah login & verifikasi
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {



    // === Admin ===
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/produk', [ProdukController::class, 'index'])->name('admin.produk.index');
        Route::get('/admin/produk/create', [ProdukController::class, 'create'])->name('produk.create');
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
    $user = Auth::user();
    if ($user->role === 'admin') {
        return redirect()->route('admin.produk.index');
    } else {
        return redirect()->route('produk.index');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

        // Laravel 8+
    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware(['auth', 'throttle:6,1'])
        ->name('verification.send');

    Route::get('/test-websocket', function() {
    event(new \App\Events\NewOrderPlaced((object)[
        'id' => 999,
        'user' => (object)['name' => 'Test User'],
        'total_price' => 50000,
        'created_at' => now()
    ]));
    
    return 'Event triggered!';
});

    Route::post('/chatbot', [ChatbotController::class, 'handle']);
});
