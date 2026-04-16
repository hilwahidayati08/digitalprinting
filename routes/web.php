<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HeroController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\PortofolioController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MaterialsController;
use App\Http\Controllers\StockLogsController;
use App\Http\Controllers\MemberRequestController; 
use App\Http\Controllers\WithdrawalController;    
use App\Http\Controllers\SaldoLogController;      
use App\Http\Controllers\NotificationController;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Village;
use App\Models\Settings;


// =========== PUBLIC ===========
Route::get('/', fn() => redirect()->route('home'));
Route::get('/home', [HomeController::class, 'home'])->name('home');


Route::get('auth/google', [AuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

Route::prefix('api')->group(function () {
    Route::get('/cities/{provinceCode}', fn($code) => City::where('province_code', $code)->orderBy('name')->get(['code', 'name']));
    Route::get('/districts/{cityCode}', fn($code) => District::where('city_code', $code)->orderBy('name')->get(['code', 'name']));
    Route::get('/villages/{districtCode}', fn($code) => Village::where('district_code', $code)->orderBy('name')->get(['code', 'name']));
});

// =========== GUEST ONLY (belum login) ===========
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showlogin'])->name('login');
    Route::post('/login', [AuthController::class, 'proseslogin'])->name('login.post');

    Route::get('/register', [AuthController::class, 'showregister'])->name('register');
    Route::post('/register', [AuthController::class, 'prosesregister'])->name('register.post');
    Route::get('/register/verify', [AuthController::class, 'showRegisterVerify'])->name('register.verify');
    Route::post('/register/verify', [AuthController::class, 'verifyRegisterOtp'])->name('register.verify.process');

    Route::prefix('password')->name('password.')->group(function () {
        Route::get('forgot', [AuthController::class, 'showForgotForm'])->name('request');
        Route::post('forgot', [AuthController::class, 'sendOtp'])->name('email');
        Route::get('verify/{token}', [AuthController::class, 'showVerifyForm'])->name('verify.form');
        Route::post('verify/{token}', [AuthController::class, 'verifyOtp'])->name('verify');
        Route::get('reset/{token}', [AuthController::class, 'showResetForm'])->name('reset.form');
        Route::post('reset/{token}', [AuthController::class, 'resetPassword'])->name('reset');
    });
});

// =========== ADMIN ONLY ===========
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Orders Admin

    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::get('/admin/report', [OrderController::class, 'report'])->name('admin.orders.report');
    Route::get('/admin/report/pdf', [OrderController::class, 'reportPdf'])->name('admin.orders.report.pdf'); 
    Route::get('/ordersadmin', [OrderController::class, 'adminIndex'])->name('admin.orders.index');
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');
    // Master Data
    Route::resource('categories', CategoryController::class);
Route::resource('heros', HeroController::class)->except(['edit', 'create', 'show']);
    Route::resource('units', UnitController::class);
    Route::resource('faqs', FaqController::class);

    Route::get('/admin/products', [ProductController::class, 'indexAdmin'])->name('products.index');

    Route::get('/admin/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/admin/products', [ProductController::class, 'store'])->name('products.store');

    Route::get('/admin/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/admin/products/{id}', [ProductController::class, 'update'])->name('products.update');

    Route::delete('/admin/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

    Route::get('/admin/portofolios', [PortofolioController::class, 'indexAdmin'])->name('portofolios.index');
    Route::get('/admin/portofolios/create', [PortofolioController::class, 'create'])->name('portofolios.create');
    Route::post('/admin/portofolios', [PortofolioController::class, 'store'])->name('portofolios.store');
    Route::get('/admin/portofolios/{id}/edit', [PortofolioController::class, 'edit'])->name('portofolios.edit');
    Route::put('/admin/portofolios/{id}', [PortofolioController::class, 'update'])->name('portofolios.update');
    Route::delete('/admin/portofolios/{id}', [PortofolioController::class, 'destroy'])->name('portofolios.destroy');
    Route::resource('users', UserController::class)->except(['editProfile', 'updateProfile', 'show']);
    Route::resource('services', ServiceController::class);
    Route::resource('stocklogs', StockLogsController::class);
    Route::resource('materials', MaterialsController::class);
    Route::post('materials/{id}/update-stock', [MaterialsController::class, 'updateStock'])->name('materials.updateStock');

    // ===== TAMBAHAN KOMISI - ADMIN =====
    Route::post('/users/{id}/toggle-member', [UserController::class, 'toggleMember'])->name('users.toggle-member');
    Route::post('/users/{id}/set-commission-rate', [UserController::class, 'setCommissionRate'])->name('users.set-commission-rate');

    Route::prefix('member-requests')->name('member-requests.')->group(function () {
        Route::get('/', [MemberRequestController::class, 'adminIndex'])->name('index');
        Route::post('/{id}/approve', [MemberRequestController::class, 'approve'])->name('approve');
        Route::post('/{id}/reject', [MemberRequestController::class, 'reject'])->name('reject');
    });

    Route::prefix('withdrawals')->name('admin.withdrawals.')->group(function () {
        Route::get('/', [WithdrawalController::class, 'adminIndex'])->name('index');
            Route::post('/admin-store', [WithdrawalController::class, 'adminStore'])->name('adminStore'); // ← TAMBAHKAN INI

        Route::post('/{id}/approve', [WithdrawalController::class, 'approve'])->name('approve');
        Route::post('/{id}/reject', [WithdrawalController::class, 'reject'])->name('reject');
    });

    Route::get('/admin-saldo-logs', [SaldoLogController::class, 'adminIndex'])->name('admin.saldo-logs.index');
    Route::post('/admin/orders/{id}/confirm-cash', [OrderController::class, 'confirmCash'])->name('orders.confirmCash');
Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');

});

// =========== USER (sudah login, semua role termasuk admin) ===========
Route::middleware(['auth', 'role:admin,user'])->group(function () {
    Route::get('/profile', [App\Http\Controllers\UserController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile', [App\Http\Controllers\UserController::class, 'updateProfile'])->name('profile.update');
    
    // Security route baru
    Route::get('/security', [App\Http\Controllers\UserController::class, 'editSecurity'])->name('profile.security');
    Route::put('/security', [App\Http\Controllers\UserController::class, 'updateSecurity'])->name('security.update');

    Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/products', [ProductController::class, 'index'])->name('products');
    Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');
    Route::resource('profiles', ProfileController::class);
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    // Rating
    Route::post('/rating/store', [RatingController::class, 'store'])->name('rating.store');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
    // Shipping
    Route::resource('shippings', ShippingController::class);

    // Orders - User
    Route::post('/orders/{orderNumber}/snap-token', [OrderController::class, 'getSnapToken'])->name('orders.snap-token');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/orders/{order_number}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/download-invoice/{order_number}', [OrderController::class, 'downloadInvoice'])->name('orders.invoice');
    Route::post('/orders/upload-design/{id}', [OrderController::class, 'uploadDesign'])->name('orders.upload');
    // web.php
// Ganti PATCH → POST
    Route::post('/orders/{id}/notes', [OrderController::class, 'updateNotes'])->name('orders.update-notes');
    Route::post('/orders/update-status/{id}', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    Route::get('/orders/{order_number}/resi', [OrderController::class, 'downloadResi'])->name('orders.resi');
    Route::post('/orders/rate', [OrderController::class, 'storeRating'])->name('orders.rate');
    // ===== TAMBAHAN KOMISI - USER =====
    Route::post('/member/request', [MemberRequestController::class, 'store'])->name('member.request');
    Route::get('/withdrawal', [WithdrawalController::class, 'index'])->name('withdrawal.index');
    Route::post('/withdrawal/store', [WithdrawalController::class, 'store'])->name('withdrawal.store');
    Route::get('/saldo-logs', [SaldoLogController::class, 'index'])->name('saldo.logs');
    Route::post('/orders/cancel/{id}', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::post('/orders/{id}/confirm-received', [OrderController::class, 'confirmReceived'])
    ->name('orders.confirm-received');

});

Route::get('/contact', function () {
    $settings = Settings::first(); // Mengambil data alamat/WA kamu
    return view('contact', compact('settings'));
})->name('contact');

Route::get('/portofolio/{slug}', [PortofolioController::class, 'show'])->name('portfolio.show');    // Cart
Route::get('/portofolio', [PortofolioController::class, 'index'])->name('portofolio.index');


Route::get('/api/search-users', [OrderController::class, 'searchUsers']);
Route::get('/api/search-products', [OrderController::class, 'searchProducts']);
// Konfirmasi cash manual oleh admin
Route::post('/midtrans/callback', [OrderController::class, 'handleNotification']);
Route::post('/midtrans/notification', [OrderController::class, 'handleNotification']);

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/{id}/read', [NotificationController::class, 'read'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'readAll'])->name('notifications.readAll');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::delete('/notifications/clear-read', [NotificationController::class, 'destroyRead'])->name('notifications.destroyRead');
    Route::get('/notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('notifications.unreadCount');
Route::post('/cart/buy-now', [CartController::class, 'buyNow'])->name('cart.buyNow')->middleware('auth');