<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AdminVendorController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController as PublicProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Vendor\ProductController as VendorProductController;
use App\Http\Controllers\VendorController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::get('/products', [PublicProductController::class, 'index'])->name('products.index');
Route::get('/prebuilt-pcs', [PublicProductController::class, 'prebuilt'])->name('products.prebuilt');
Route::get('/products/{id}', [PublicProductController::class, 'show'])
    ->middleware('auth')
    ->name('products.show');

Route::middleware('auth')->group(function () {
    // Profile management for signed-in users.
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Cart and client order actions.
    Route::get('/cart', [OrderController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [OrderController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/update/{id}', [OrderController::class, 'updateItem'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [OrderController::class, 'removeItem'])->name('cart.remove');
    Route::get('/payment', [OrderController::class, 'payment'])->name('payment.page');
    Route::post('/payment/confirm', [OrderController::class, 'confirmPayment'])->name('payment.confirm');
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('cart.checkout');
    Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('orders.index');

    // Vendor request flow.
    Route::get('/become-vendor', [VendorController::class, 'create'])->name('vendor.request.form');
    Route::post('/become-vendor', [VendorController::class, 'requestVendor'])->name('vendor.request');
});

Route::middleware(['auth', 'role:vendor'])->prefix('vendor')->group(function () {
    // Vendors manage only their own products and orders.
    Route::get('/prebuilt-pcs/create', [VendorProductController::class, 'createPrebuilt'])->name('vendor.products.prebuilt.create');
    Route::post('/prebuilt-pcs', [VendorProductController::class, 'storePrebuilt'])->name('vendor.products.prebuilt.store');
    Route::resource('products', VendorProductController::class)->names('vendor.products');
    Route::get('/orders', [OrderController::class, 'vendorOrders'])->name('vendor.orders');
    Route::post('/orders/{id}/ship', [OrderController::class, 'markAsShipped'])->name('vendor.orders.ship');
    Route::post('/orders/{id}/deliver', [OrderController::class, 'markAsDelivered'])->name('vendor.orders.deliver');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    // Admin oversight routes.
    Route::get('/orders', [OrderController::class, 'adminOrders'])->name('admin.orders');
    Route::get('/vendors', [AdminVendorController::class, 'index'])->name('admin.vendors.index');
    Route::post('/vendors/{id}/approve', [AdminVendorController::class, 'approve'])->name('admin.vendors.approve');
    Route::post('/vendors/{id}/reject', [AdminVendorController::class, 'reject'])->name('admin.vendors.reject');
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
});

require __DIR__.'/auth.php';
