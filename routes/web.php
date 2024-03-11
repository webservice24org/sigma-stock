<?php

use App\Http\Controllers\Admin\CustomerCategoryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SupplierController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('layouts.index');
    })->name('dashboard');


    Route::resource('customers', CustomerController::class);
    Route::resource('customers-categories', CustomerCategoryController::class)->except(['show', 'create']);

    Route::resource('product-categories', ProductCategoryController::class)->except(['show', 'create']);
    Route::resource('products', ProductController::class)->except(['create']);


    Route::resource('suppliers', SupplierController::class);

    Route::get('/users', [SupplierController::class, 'allUsers']);
});


//Route::get('user-details/{id}', [SupplierController::class, 'userDetails']);