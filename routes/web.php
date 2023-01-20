<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SellingController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AuthController as Admin_Auth;
use App\Http\Controllers\Admin\DashboardController as Admin_Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['guest'])->group(function () {
    Route::match(['get', 'post'], '/login', [AuthController::class, 'login'])->name('login');
    Route::match(['get', 'post'], '/admin/login', [Admin_Auth::class, 'login'])->name('admin-login');
});

Route::middleware(['admin'])->group(function () {
    Route::post('/admin/logout', [Admin_Auth::class, 'logout'])->name('admin-logout');

    Route::get('/admin', [Admin_Dashboard::class, 'index'])->name('admin-dashboard');

    Route::resource('/admin/user', UserController::class)->except('show');;
});

Route::middleware(['store'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/account', [AccountController::class, 'index'])->name('account.index');
    Route::match(['get', 'post'], '/account/change-password', [AccountController::class, 'changePassword'])->name('account.change-password');

    Route::resource('/product', ProductController::class)->except('show');

    Route::get('/purchase', [PurchaseController::class, 'index'])->name('purchase');
    Route::post('/purchase', [PurchaseController::class, 'store'])->name('purchase.store');
    Route::post('/purchase-temporary', [PurchaseController::class, 'temporaryStore'])->name('purchase-temporary.store');
    Route::put('/purchase-temporary/{purchase_temporary_detail}', [PurchaseController::class, 'temporaryUpdate'])->name('purchase-temporary.update');
    Route::delete('/purchase-temporary/{purchase_temporary_detail}', [PurchaseController::class, 'temporaryDestroy'])->name('purchase-temporary.destroy');

    Route::get('/selling', [SellingController::class, 'index'])->name('selling');
    Route::post('/selling', [SellingController::class, 'store'])->name('selling.store');
    Route::post('/selling-temporary', [SellingController::class, 'temporaryStore'])->name('selling-temporary.store');
    Route::put('/selling-temporary/{selling_temporary_detail}', [SellingController::class, 'temporaryUpdate'])->name('selling-temporary.update');
    Route::delete('/selling-temporary/{selling_temporary_detail}', [SellingController::class, 'temporaryDestroy'])->name('selling-temporary.destroy');

    Route::get('/report-purchase', [ReportController::class, 'purchase'])->name('report.purchase');
    Route::get('/report-purchase/{code}', [ReportController::class, 'purchaseDetail'])->name('report.purchase.detail');

    Route::get('/report-selling', [ReportController::class, 'selling'])->name('report.selling');
    Route::get('/report-selling/{code}', [ReportController::class, 'sellingDetail'])->name('report.selling.detail');

    Route::get('/selling-print', [PrintController::class, 'selling'])->name('print');
    Route::get('/report-selling/print/{code}', [PrintController::class, 'sellingPrint'])->name('report.selling.print');
});
