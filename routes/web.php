<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/dashboard', [UserController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('admin')->group(function () {

    Route::get('/add_category', [AdminController::class, 'addCategory'])->name('add_category');
    Route::post('/add_category', [AdminController::class, 'postAddCategory'])->name('post_add_category');
    Route::get('/view_category', [AdminController::class, 'viewCategory'])->name('view_category');
    /* delete category */
    Route::delete('/delete_category/{id}', [AdminController::class, 'deleteCategory'])->name('delete_category');
    /* update category */
    Route::get('/update_category/{id}', [AdminController::class, 'updateCategoryForm'])->name('update_category_form');
    Route::put('/update_category/{id}', [AdminController::class, 'updateCategory'])->name('update_category');

    /* add product */
    Route::get('/add_product', [AdminController::class, 'addProduct'])->name('add_product');
    Route::post('/add_product', [AdminController::class, 'postAddProduct'])->name('post_add_product');
    /* view product */
    Route::get('/view_product', [AdminController::class, 'viewProduct'])->name('view_product');
    /* edit product */
    Route::get('/edit_product/{id}', [AdminController::class, 'editProduct'])->name('edit_product');
    Route::put('/update_product/{id}', [AdminController::class, 'updateProduct'])->name('update_product');
    /* delete product */
    Route::delete('/delete_product/{id}', [AdminController::class, 'deleteProduct'])->name('delete_product');
    /* view order */
    Route::get('/view_order', [AdminController::class, 'viewOrder'])->name('view_order');
});

require __DIR__ . '/auth.php';
