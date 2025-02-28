<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\DashboardController;

Route::view('/', 'welcome');


// products

// locations
Route::resource('locations', LocationController::class)->middleware(['auth', 'verified']);

// stocks
Route::get('stocks/{productId}/details', [StockController::class, 'details'])->middleware(['auth', 'verified'])->name('stocks.details');
Route::get('stocks/{stockId}/{productId}/add', [StockController::class, 'add'])->middleware(['auth', 'verified'])->name('stocks.add');
Route::get('stocks/{stockId}/{productId}/trasnfer', [StockController::class, 'transfers'])->middleware(['auth', 'verified'])->name('stocks.transfers');
Route::get('stocks/{stockId}/{productId}/editqnty', [StockController::class, 'editQnty'])->middleware(['auth', 'verified'])->name('stocks.editqnty');
Route::get('stocks/{stockId}/{productId}/confim', [StockController::class, 'confirmTransfer'])->middleware(['auth', 'verified'])->name('confirm.transfers');
Route::resource('stocks', StockController::class)->middleware(['auth', 'verified']);





Route::get('receipt/{orderId}', [PosController::class, 'receipt'])
    ->middleware(['auth', 'verified'])->name('receipt');

// Route::get('receipt/{orderId}', [MikePrinter::class, 'receipt'])
//     ->middleware(['auth', 'verified'])->name('receipt');

Route::group(['middleware' => ['auth', 'verified']], function() {
    // products
    Route::get('products/import', [ProductController::class, 'import'])->name('products.import');
    Route::resource('products', ProductController::class);

    // pos
    Route::get('pos', [PosController::class, 'index'])->name('pos');

    // orders
    Route::get('orders', [OrderController::class, 'index'])->name('orders');
    Route::get('orders/import', [OrderController::class, 'import'])->name('orders.import');


    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::get('roles/edit/{$id}', [RoleController::class, 'edit'])->name('roles.edit');
    Route::resource('permissions', PermissionController::class);
    Route::resource('users', UserController::class);

    Route::get('stocklogs', [LogController::class, 'stockLogs'])->name('stocklogs.index');
    Route::get('reports/sales', [ReportController::class, 'sales'])->name('sales.index');
    Route::get('reports/sales/download/{ids}', [ReportController::class, 'salesDownload'])->name('reports.sales.download');
    Route::get('currency/{name}', [CurrencyController::class, 'change'])->name('currency');
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
