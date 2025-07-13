<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Homepage Route
Route::get('/', [HomeController::class, 'index'])->name('index');

// Product Detail Route
Route::get('/product/{id}', [HomeController::class, 'productDetail'])->name('product.detail');

// Cart Routes
Route::prefix('cart')->name('cart.')->group(function () {
    Route::post('/add', [CartController::class, 'addToCart'])->name('add');
    Route::get('/count', [CartController::class, 'getCartCount'])->name('count');
    Route::get('/view', [CartController::class, 'viewCart'])->name('view');
    Route::post('/update', [CartController::class, 'updateCart'])->name('update');
    Route::delete('/remove/{id}', [CartController::class, 'removeFromCart'])->name('remove');
});

// Checkout Routes
Route::prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/data', [CheckoutController::class, 'getCheckoutData'])->name('data');
    Route::post('/process', [CheckoutController::class, 'processCheckout'])->name('process');
    Route::get('/receipt/{orderId}', [CheckoutController::class, 'downloadReceipt'])->name('receipt');
});

// CSRF Token refresh route
Route::get('/csrf-token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
});

// Redirect /dashboard to admin dashboard
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Redirect standard register to customer register
Route::get('/register', function () {
    return redirect()->route('customer.register');
});

// Redirect standard login to customer login
Route::get('/login', function () {
    return redirect()->route('customer.login');
});

// Standard Laravel auth profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware('admin')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'adminDashboard'])->name('admin.dashboard');

    // Category Management
    Route::get('/add_category', [AdminController::class, 'addCategory'])->name('add_category');
    Route::post('/add_category', [AdminController::class, 'postAddCategory'])->name('post_add_category');
    Route::get('/view_category', [AdminController::class, 'viewCategory'])->name('view_category');
    Route::delete('/delete_category/{id}', [AdminController::class, 'deleteCategory'])->name('delete_category');
    Route::get('/update_category/{id}', [AdminController::class, 'updateCategoryForm'])->name('update_category_form');
    Route::put('/update_category/{id}', [AdminController::class, 'updateCategory'])->name('update_category');

    // Product Management
    Route::get('/add_product', [AdminController::class, 'addProduct'])->name('add_product');
    Route::post('/add_product', [AdminController::class, 'postAddProduct'])->name('post_add_product');
    Route::get('/view_product', [AdminController::class, 'viewProduct'])->name('view_product');
    Route::get('/edit_product/{id}', [AdminController::class, 'editProduct'])->name('edit_product');
    Route::put('/update_product/{id}', [AdminController::class, 'updateProduct'])->name('update_product');
    Route::delete('/delete_product/{id}', [AdminController::class, 'deleteProduct'])->name('delete_product');

    // Order Management
    Route::get('/view_order', [AdminController::class, 'viewOrder'])->name('view_order');
});

// Customer Routes
Route::prefix('customer')->name('customer.')->group(function () {
    // Guest routes (for non-authenticated customers)
    Route::middleware('guest:customer')->group(function () {
        Route::get('/register', [CustomerController::class, 'register'])->name('register');
        Route::post('/register', [CustomerController::class, 'postRegister'])->name('post.register');
        Route::get('/login', [CustomerController::class, 'login'])->name('login');
        Route::post('/login', [CustomerController::class, 'postLogin'])->name('post.login');
    });

    // Authenticated customer routes
    Route::middleware('auth:customer')->group(function () {
        Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('dashboard');
        Route::get('/edit', [CustomerController::class, 'edit'])->name('edit');
        Route::put('/update', [CustomerController::class, 'update'])->name('update');
        Route::post('/logout', [CustomerController::class, 'logout'])->name('logout');
    });
});

require __DIR__ . '/auth.php';
