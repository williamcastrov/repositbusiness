<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\IntuitController;
use App\Http\Controllers\cyclewearController;
use App\Http\Controllers\MrpServicesController;

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

// Api Rest BrokerUp
Route::post('mrp/{accion}', 'MrpServicesController@mrpGeneral');
Route::get('mrp/{accion}/{idmobile}', 'MrpServicesController@mrpGeneral');

Route::post('/endpoint/{accion}', [ApiController::class, 'receive']);
Route::post('/endpoint/{accion}/{data}', [ApiController::class, 'receiveData']);

//Intuit
Route::get('/receive/{accion}', [IntuitController::class, 'receive']);

// cyclewear

Route::post('/cyclewear/webhooks', [cyclewearController::class, 'webhooks']);
Route::any('/cyclewear/{accion}', [cyclewearController::class, 'cwrGeneral']);
Route::any('/cyclewear/{accion}/{parametro}', [cyclewearController::class, 'cwrGeneral']);