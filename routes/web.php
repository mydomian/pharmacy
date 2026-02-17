<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\StockController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('dashboard', [DashboardController::class,'dashboard'])->name('dashboard');
    Route::resource('customers', CustomerController::class);
    Route::get('customers/{id}/payment', [CustomerController::class,'customer_payment'])->name('customers.payment');
    Route::post('customers/payment/release', [CustomerController::class,'release_payment'])->name('customers.releasePayment');
    Route::resource('suppliers', SupplierController::class);
    Route::resource('units', UnitController::class);
    Route::resource('products', ProductController::class);
    Route::resource('purchases', PurchaseController::class);
    Route::get('purchases-reports', [PurchaseController::class,'reports'])->name('purchases.reports');
    Route::get('purchases/{id}/print',[PurchaseController::class,'print'])->name('purchases.print');
    Route::resource('sales', SaleController::class);
    Route::get('sales-reports', [SaleController::class,'reports'])->name('sales.reports');
    Route::get('sales/{id}/print',[SaleController::class,'print'])->name('sales.print');
    Route::get('stocks', [StockController::class,'index'])->name('stocks.index');
    Route::get('stocks/log', [StockController::class,'log'])->name('stocks.log');
    Route::resource('expenses', ExpenseController::class);
    Route::match(['get','post'],'profile',[DashboardController::class,'profile'])->name('profile');
});

require __DIR__.'/auth.php';
