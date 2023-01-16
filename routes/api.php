<?php

use App\Http\Controllers\API\DailyTaskApiController;
use App\Http\Controllers\API\DashboardApiController;
use App\Http\Controllers\API\ExpeditionApiController;
use App\Http\Controllers\API\JdIdApiController;
use App\Http\Controllers\API\lazadaApiController;
use App\Http\Controllers\API\OnlineShopeApiController;
use App\Http\Controllers\API\ShopeeApiController;
use App\Http\Controllers\API\TiktokApiController;
use App\Http\Controllers\API\TransactionOnlineApiController;
use App\Http\Controllers\TransactionOnlineController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('expedition/dataTable', [ExpeditionApiController::class, 'dataTable']);
Route::resource('expedition', ExpeditionApiController::class);

Route::get('daily-task/receipt/{id}', [DailyTaskApiController::class, 'receiptByDailyTaskId']);
Route::post('daily-task/receipt/{id}', [DailyTaskApiController::class, 'receipt']);
Route::post('daily-task/multiple', [DailyTaskApiController::class, 'multiple']);
Route::delete('daily-task/receipt/{number}', [DailyTaskApiController::class, 'deleteReceipt']);
Route::patch('daily-task/total/{id}', [DailyTaskApiController::class, 'total']);
Route::patch('daily-task/picked/{id}', [DailyTaskApiController::class, 'picked']);
Route::patch('daily-task/finish/{id}', [DailyTaskApiController::class, 'finish']);
Route::get('daily-task/dataTable', [DailyTaskApiController::class, 'dataTable']);
Route::get('daily-task/current', [DailyTaskApiController::class, 'getCurrentTask']);
Route::resource('daily-task', DailyTaskApiController::class);

Route::post('lazada-order/rts/{tracking_number}/{shipment_provider}/{order_item_ids}', [lazadaApiController::class, 'readyToShipp']);
Route::get('lazada-order/pending/{sorting}', [lazadaApiController::class, 'pending']);
Route::get('lazada-order/rts/{sorting}', [lazadaApiController::class, 'rts']);
Route::get('lazada-order/packed/{sorting}', [lazadaApiController::class, 'packed']);
Route::get('lazada/order/{status}/{sorting}', [lazadaApiController::class, 'getFullOrder']);
Route::get('lazada-order/count', [lazadaApiController::class, 'getCount']);
Route::resource('lazada-order', lazadaApiController::class);

Route::get('shopee-order/order/{orderSn}', [ShopeeApiController::class, 'getOrderByNo']);
Route::get('shopee-order/order/v2/{orderSn}', [ShopeeApiController::class, 'getOrderByNoV2']);
Route::get('shopee-order/get', [ShopeeApiController::class, 'getOrders']);
Route::post('shopee-order/rts/{orderSn}', [ShopeeApiController::class, 'rts']);
Route::resource('shopee-order', ShopeeApiController::class);

Route::get('tiktok-order/get', [TiktokApiController::class, 'getOrders']);
Route::resource('tiktok-order', TiktokApiController::class);

Route::get('jd-order/rts/{id}', [JdIdApiController::class, 'rts']);
Route::resource('jd-order', JdIdApiController::class);

Route::get('platform/active', [OnlineShopeApiController::class, 'active']);
Route::resource('platform', OnlineShopeApiController::class);

Route::resource('transaction-online', TransactionOnlineApiController::class);

Route::resource('receipt', ReceiptApiController::class);
Route::resource('dashboard', DashboardApiController::class);
