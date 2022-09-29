<?php

use App\Http\Controllers\API\DailyTaskApiController;
use App\Http\Controllers\API\ExpeditionApiController;
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

Route::post('daily-task/receipt/{id}', [DailyTaskApiController::class, 'receipt']);
Route::delete('daily-task/receipt/{number}', [DailyTaskApiController::class, 'deleteReceipt']);
Route::patch('daily-task/total/{id}', [DailyTaskApiController::class, 'total']);
Route::get('daily-task/dataTable', [DailyTaskApiController::class, 'dataTable']);
Route::get('daily-task/current', [DailyTaskApiController::class, 'getCurrentTask']);
Route::resource('daily-task', DailyTaskApiController::class);

Route::resource('receipt', ReceiptApiController::class);
