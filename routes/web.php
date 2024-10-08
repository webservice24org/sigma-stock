<?php

use App\Http\Controllers\Admin\CustomerCategoryController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\HrmDepartmentController;
use App\Http\Controllers\Admin\ProductUnitController;
use App\Http\Controllers\Admin\PurchaseCategoryController;
use App\Http\Controllers\Admin\PurchaseController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\QuotationController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\WarehouseController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
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
    Route::post('product/update/{id}', [ProductController::class, 'update'])->name('product.update');


    Route::resource('suppliers', SupplierController::class);
    Route::put('/suppliers/{id}/status', [SupplierController::class, 'updateStatus'])->name('suppliers.updateStatus');

    //Route::get('/users', [SupplierController::class, 'allUsers']);

    Route::resource('/hrm-departments', HrmDepartmentController::class);
    Route::resource('/employees', EmployeeController::class);
    Route::get('/departments', [EmployeeController::class, 'allDepartments']);
    Route::put('/employees/{id}/status', [EmployeeController::class, 'updateStatus'])->name('employees.updateStatus');

    Route::resource('/warehouses', WarehouseController::class);

    Route::resource('/product-units', ProductUnitController::class);

    Route::resource('/purchase-categories', PurchaseCategoryController::class);

    Route::resource('/purchases', PurchaseController::class);
    Route::get('/all-suppliers', [PurchaseController::class, 'allSuppliers'])->name('allSuppliers');
    Route::get('/all-warehouses', [PurchaseController::class, 'allwarehouses'])->name('allwarehouses');
    Route::get('/all-purchase-cats', [PurchaseController::class, 'allPurchseCats'])->name('allPurchseCats');
    Route::get('/all-units', [PurchaseController::class, 'allUnits'])->name('allUnits');

    Route::resource('/quotations', QuotationController::class);


    Route::resource('/permissions', PermissionController::class);
    Route::delete('/permissions/{permissionId}', [PermissionController::class, 'destroy'])->name('permissions.destroy');


    Route::resource('/roles', RoleController::class);
    Route::get('/roles/{roleId}/give-permissions', [RoleController::class,'givePermission'])->name('givePermission');
    Route::put('/roles/{roleId}/give-permissions', [RoleController::class,'updatePermission'])->name('updatePermission');
    Route::delete('/roles/{roleId}', [RoleController::class, 'destroy'])->name('roles.destroy');


    Route::resource('/users', UserController::class);
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');

    
});


//Route::get('user-details/{id}', [SupplierController::class, 'userDetails']);