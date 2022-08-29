<?php

use App\Http\Controllers\AtmController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DirectSalesController;
use App\Http\Controllers\ItemConvertionController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MultipleDiscountController;
use App\Http\Controllers\MultipleDiscountDetailController;
use App\Http\Controllers\PaymentTypeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UomController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/login', [LoginController::class, 'index'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/', [DashboardController::class, 'index'])->middleware('auth');
Route::resource('user', UserController::class)->middleware('auth');

Route::put('product/status', [ProductController::class, 'changeStatus'])->middleware('auth');
Route::resource('product', ProductController::class)->middleware('auth');

Route::put('category/status', [CategoryController::class, 'changeStatus'])->middleware('auth');
Route::resource('category', CategoryController::class)->middleware('auth');

Route::put('uom/status', [UomController::class, 'changeStatus'])->middleware('auth');
Route::resource('uom', UomController::class)->middleware('auth');

Route::put('bank/status', [AtmController::class, 'changeStatus'])->middleware('auth');
Route::resource('bank', AtmController::class)->middleware('auth');

Route::put('payment/default', [PaymentTypeController::class, 'changePayment'])->middleware('auth');
Route::put('payment/status', [PaymentTypeController::class, 'changeStatus'])->middleware('auth');
Route::resource('payment', PaymentTypeController::class)->middleware('auth');

Route::resource('supplier', SupplierController::class)->middleware('auth');

Route::resource('setting', SettingController::class)->middleware('auth');
Route::resource('transaction', DirectSalesController::class)->middleware('auth');
Route::resource('multiple-discount', MultipleDiscountController::class)->middleware('auth');
Route::resource('multiple-discount-detail', MultipleDiscountDetailController::class)->middleware('auth');

Route::get('item-convertion/dataTable', [ItemConvertionController::class, 'dataTable'])->middleware('auth');
