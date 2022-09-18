<?php

use App\Http\Controllers\API\ExpeditionController;
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


Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api', 'middleware' => ['auth:api']], function () {
    // Permissions
    Route::resource('api/expedition', ExpeditionController::class)->middleware('auth');

    // // Roles
    // Route::apiResource('roles', 'RolesApiController');

    // // Users
    // Route::apiResource('users', 'UsersApiController');

    // // Products
    // Route::apiResource('products', 'ProductsApiController');

    // // Orders
    // Route::apiResource('orders', 'OrdersApiController');
});
