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

    Route::get('/add_category', [AdminController::class, 'addCategory'])->name('addcategory');

    Route::post('/add_category', [AdminController::class, 'postAddCategory'])->name('postaddcategory');
    Route::get('/view_category', [AdminController::class, 'viewCategory'])->name('viewcategory');
    /* delete category */
    Route::delete('/delete_category/{id}', [AdminController::class, 'deleteCategory'])->name('deletecategory');
    /* edit category */
    Route::post('/update_category/{id}', [AdminController::class, 'postUpdateCategory'])->name('postupdatecategory');
    /* update category */
    Route::get('/update_category/{id}', [AdminController::class, 'updateCategoryForm'])->name('updatecategoryform');
    Route::put('/update_category/{id}', [AdminController::class, 'updateCategory'])->name('updatecategory');
});

require __DIR__ . '/auth.php';
