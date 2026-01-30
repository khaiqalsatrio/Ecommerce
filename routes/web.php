<?php

use App\Http\Controllers\Admin\CategoryAdminController;
use Illuminate\Support\Facades\Route;

// AUTH
use App\Http\Controllers\Auth\AuthController;

use App\Http\Controllers\Admin\UserController;

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
use App\Http\Controllers\buyer\ProfileController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES (NO LOGIN REQUIRED)
|--------------------------------------------------------------------------
*/

// HOME
Route::get('/', [DashboardBuyerController::class, 'index'])->name('home');

// PRODUCTS
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

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


Route::middleware(['auth'])->prefix('admin')->group(function () {

    Route::get('/users', [UserController::class, 'index'])
        ->name('admin.data-user');

    Route::delete('/users/{user}', [UserController::class, 'destroy'])
        ->name('admin.users.destroy');
});


/*
|--------------------------------------------------------------------------
| BUYER ROUTES (LOGIN REQUIRED)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'buyer'])
    ->prefix('buyer')
    ->as('buyer.')
    ->group(function () {

        // CART
        Route::get('/cart', [CartController::class, 'index'])
            ->name('cart.index');

        Route::post('/cart/add/{id}', [CartController::class, 'add'])
            ->name('cart.add');

        Route::post('/cart/remove/{id}', [CartController::class, 'remove'])
            ->name('cart.remove');

        Route::post('/cart/update/{id}', [CartController::class, 'update'])
            ->name('cart.update');

        // PRODUCTS
        Route::get('/products', [ProductController::class, 'index'])
            ->name('products.index');

        Route::get('/products/{slug}', [ProductController::class, 'show'])
            ->name('products.show');

        // CHECKOUT
        Route::get('/checkout', [CheckoutController::class, 'show'])
            ->name('checkout.show');

        Route::post('/checkout/process', [CheckoutController::class, 'process'])
            ->name('checkout.process');

        // PAYMENT
        Route::get('/payment/{order}', [PaymentController::class, 'index'])
            ->name('payment.index');

        Route::post('/payment/confirm', [PaymentController::class, 'confirm'])
            ->name('payment.confirm');

        // PROFILE (BUYER ONLY)
        Route::get('/profile', function () {
            return view('auth.profile');
        })->name('profile');

        Route::put('/profile', [ProfileController::class, 'update'])
            ->name('profile.update');
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

        // USERS
        Route::get('/users', [UserController::class, 'index'])
            ->name('data-user');

        Route::delete('/users/{user}', [UserController::class, 'destroy'])
            ->name('users.destroy');

        // PRODUCTS
        Route::resource('products', ProductAdminController::class)
            ->except(['show']);

        // CATEGORIES
        Route::resource('categories', CategoryAdminController::class)
            ->except(['show']);

        // ORDERS
        Route::get('/orders', [OrderAdminController::class, 'index'])
            ->name('orders.index');

        Route::get('/orders/{order}', [OrderAdminController::class, 'show'])
            ->name('orders.show');

        Route::put('/orders/{order}/status', [OrderAdminController::class, 'updateStatus'])
            ->name('orders.updateStatus');

        // ✅ PRINT STRUK
        Route::get('/orders/{order}/print', [OrderAdminController::class, 'print'])
            ->name('print');
    });
