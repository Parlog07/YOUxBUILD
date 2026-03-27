<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware('auth')->group(function () {

    Route::get('/cart', [OrderController::class, 'index'])->name('cart.index');

    Route::post('/cart/add', [OrderController::class, 'addToCart'])->name('cart.add');

    Route::post('/cart/update/{id}', [OrderController::class, 'updateItem'])->name('cart.update');

    Route::delete('/cart/remove/{id}', [OrderController::class, 'removeItem'])->name('cart.remove');

    Route::post('/checkout', [OrderController::class, 'checkout'])->name('cart.checkout');
});
Route::get('/my-orders', [OrderController::class, 'myOrders'])
    ->name('orders.index')
    ->middleware('auth');

    Route::get('/', function () {
    return view('welcome'); // or your homepage
})->name('home');




    
require __DIR__.'/auth.php';
