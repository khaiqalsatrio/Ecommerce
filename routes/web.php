<?php

use Illuminate\Support\Facades\Route;

// AUTH
use App\Http\Controllers\Auth\AuthController;

// BUYER
use App\Http\Controllers\Buyer\ProductController;
use App\Http\Controllers\Buyer\CartController;
use App\Http\Controllers\Buyer\CheckoutController;
use App\Http\Controllers\Buyer\PaymentController;

// ADMIN
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductAdminController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\OrderAdminController;

/*
|--------------------------------------------------------------------------
| AUTH ROUTE
|--------------------------------------------------------------------------
*/

Route::get('/login', fn() => view('auth.login'))->name('login');
Route::get('/register', fn() => view('auth.register'));

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

/*
|--------------------------------------------------------------------------
| BUYER ROUTE
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/', fn() => view('buyer.welcome'));

    Route::get('/home', fn() => view('buyer.home'));

    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{id}', [ProductController::class, 'show']);

    Route::post('/cart/add/{id}', [CartController::class, 'add']);
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart/remove/{id}', [CartController::class, 'remove']);

    Route::get('/checkout', [CheckoutController::class, 'index']);
    Route::post('/checkout/process', [CheckoutController::class, 'process']);

    Route::get('/payment/{order}', [PaymentController::class, 'index']);
    Route::post('/payment/confirm', [PaymentController::class, 'confirm']);
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTE
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index']);

    // product admin
    Route::get('/products', [ProductAdminController::class, 'index']);
    Route::get('/products/create', [ProductAdminController::class, 'create']);
    Route::post('/products', [ProductAdminController::class, 'store']);
    Route::get('/products/{id}/edit', [ProductAdminController::class, 'edit']);
    Route::put('/products/{id}', [ProductAdminController::class, 'update']);
    Route::delete('/products/{id}', [ProductAdminController::class, 'destroy']);

    // order admin
    Route::get('/orders', [OrderAdminController::class, 'index']);
    Route::get('/orders/{id}', [OrderAdminController::class, 'show']);
    Route::post('/orders/{id}/status', [OrderAdminController::class, 'updateStatus']);
});
