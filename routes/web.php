<?php

use App\Http\Controllers\Admin\CustomerCategoryController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\HrmDepartmentController;
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

    Route::resource('customers-categories', CustomerCategoryController::class);

    Route::resource('suppliers', SupplierController::class);
    Route::put('/suppliers/{id}/status', [SupplierController::class, 'updateStatus'])->name('suppliers.updateStatus');


    Route::get('/users', [SupplierController::class, 'allUsers']);
    
    Route::resource('/hrm-departments', HrmDepartmentController::class);
    Route::resource('/employees', EmployeeController::class);
    Route::get('/departments', [EmployeeController::class, 'allDepartments']);
});


//Route::get('user-details/{id}', [SupplierController::class, 'userDetails']);