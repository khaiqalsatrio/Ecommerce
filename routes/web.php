<?php

use App\Http\Controllers\Admin\CategoryAdminController;
use Illuminate\Support\Facades\Route;

// AUTH
use App\Http\Controllers\Auth\AuthController;

// BUYER
use App\Http\Controllers\Buyer\ProductController;
use App\Http\Controllers\Buyer\CartController;
use App\Http\Controllers\Buyer\CheckoutController;
use App\Http\Controllers\Buyer\PaymentController;
use App\Http\Controllers\Buyer\DashboardBuyerController;

// ADMIN
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductAdminController;
use App\Http\Controllers\Admin\OrderAdminController;


/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES (NO LOGIN REQUIRED)
|--------------------------------------------------------------------------
*/

// HOME
Route::get('/', [DashboardBuyerController::class, 'index'])->name('home');

// PRODUCTS
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show'); // ✅ Ubah dari {product} ke {id}

// CART (VIEW ONLY)
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/login', fn() => view('auth.login'))->name('login');
Route::get('/register', fn() => view('auth.register'));

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| BUYER ROUTES (LOGIN REQUIRED)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'buyer'])
    ->prefix('buyer')
    ->as('buyer.')
    ->group(function () {

        // ADD / REMOVE CART
        Route::post('/cart/add/{id}', [CartController::class, 'add'])
            ->name('cart.add');

        Route::post('/cart/remove/{id}', [CartController::class, 'remove'])
            ->name('cart.remove');

        // CHECKOUT
        Route::get('/checkout', [CheckoutController::class, 'index'])
            ->name('checkout.index');

        Route::post('/checkout/process', [CheckoutController::class, 'process'])
            ->name('checkout.process');

        // PAYMENT
        Route::get('/payment/{order}', [PaymentController::class, 'index'])
            ->name('payment.index');

        Route::post('/payment/confirm', [PaymentController::class, 'confirm'])
            ->name('payment.confirm');
    });

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES (LOGIN REQUIRED)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->as('admin.')
    ->group(function () {

        // DASHBOARD
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        // PRODUCTS
        Route::get('/products', [ProductAdminController::class, 'index'])
            ->name('products.index');
        Route::get('/products/create', [ProductAdminController::class, 'create'])
            ->name('products.create');
        Route::post('/products', [ProductAdminController::class, 'store'])
            ->name('products.store');
        Route::get('/products/{product}/edit', [ProductAdminController::class, 'edit'])
            ->name('products.edit');
        Route::put('/products/{product}', [ProductAdminController::class, 'update'])
            ->name('products.update');
        Route::delete('/products/{product}', [ProductAdminController::class, 'destroy'])
            ->name('products.destroy');

        // CATEGORIES
        Route::get('/categories', [CategoryAdminController::class, 'index'])
            ->name('categories.index');
        Route::get('/categories/create', [CategoryAdminController::class, 'create'])
            ->name('categories.create');
        Route::post('/categories', [CategoryAdminController::class, 'store'])
            ->name('categories.store');
        Route::get('/categories/{category}/edit', [CategoryAdminController::class, 'edit'])
            ->name('categories.edit');
        Route::put('/categories/{category}', [CategoryAdminController::class, 'update'])
            ->name('categories.update');
        Route::delete('/categories/{category}', [CategoryAdminController::class, 'destroy'])
            ->name('categories.destroy');

        // ORDERS
        Route::get('/orders', [OrderAdminController::class, 'index'])
            ->name('orders.index');
        Route::get('/orders/{order}', [OrderAdminController::class, 'show'])
            ->name('orders.show');
        Route::post('/orders/{order}/status', [OrderAdminController::class, 'updateStatus'])
            ->name('orders.status');
    });
