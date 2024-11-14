<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\servicareController;

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

Route::get('/', function () {
    phpinfo(); //return view('welcome');
});

/******************************************* */
// ACCIONES DE MERCADO RESPUESTO
////////////////////////////////////////////////
// Web Services WC.AAL-ERP
Route::post('mrp/api/{accion}', 'App\Http\Controllers\MrpServicesController@mrpGeneral');
Route::post('mrp/api/{accion}/', 'App\Http\Controllers\MrpServicesController@mrpGeneral');
Route::post('mrp/api/{accion}/{parametro}', 'App\Http\Controllers\MrpServicesController@mrpGeneral');
Route::get('mrp/api/{accion}', 'App\Http\Controllers\MrpServicesController@mrpGeneral');
Route::get('mrp/api/{accion}/', 'App\Http\Controllers\MrpServicesController@mrpGeneral');
Route::get('mrp/api/{accion}/{parametro}', 'App\Http\Controllers\MrpServicesController@mrpGeneral');

// ACCIONES BROKER UP
////////////////////////////////////////////////
// Web Services Broker Up
Route::post('bru/api/{accion}', 'App\Http\Controllers\brokerupController@bruGeneral');
Route::post('bru/api/{accion}/', 'App\Http\Controllers\brokerupController@bruGeneral');
Route::post('bru/api/{accion}/{parametro}', 'App\Http\Controllers\brokerupController@bruGeneral');
Route::get('bru/api/{accion}', 'App\Http\Controllers\brokerupController@bruGeneral');
Route::get('bru/api/{accion}/', 'App\Http\Controllers\brokerupController@bruGeneral');
Route::get('bru/api/{accion}/{parametro}', 'App\Http\Controllers\brokerupController@bruGeneral');

////////////////////////////////////////////////

/******************************************* */
// ACCIONES DE CYCLE WEAR
////////////////////////////////////////////////
// Web Services CYCLE WEAR
Route::post('cyclewear/api/{accion}', 'App\Http\Controllers\cyclewearController@cwrGeneral');
Route::post('cyclewear/api/{accion}/{parametro}', 'App\Http\Controllers\cyclewearController@cwrGeneral');
Route::get('cyclewear/api/{accion}', 'App\Http\Controllers\cyclewearController@cwrGeneral');
Route::get('cyclewear/api/{accion}/{parametro}', 'App\Http\Controllers\cyclewearController@cwrGeneral');

/******************************************* */
// ACCIONES DE GIMCLOUD LOGISTRAL
////////////////////////////////////////////////
// Web Services GIM Cloud
Route::post('gimcloud/api/{accion}', 'App\Http\Controllers\gimcloudController@logistralGimGeneral');
Route::post('gimcloud/api/{accion}/{parametro}', 'App\Http\Controllers\gimcloudController@logistralGimGeneral');
Route::get('gimcloud/api/{accion}', 'App\Http\Controllers\gimcloudController@logistralGimGeneral');
Route::get('gimcloud/api/{accion}/{parametro}', 'App\Http\Controllers\gimcloudController@logistralGimGeneral');

/******************************************* */
// ACCIONES CONSTRUCTORA
////////////////////////////////////////////////
// Web Services Constructora
Route::post('constructora/api/{accion}', 'App\Http\Controllers\constructoraController@ConstructoraGeneral');
Route::post('constructora/api/{accion}/{parametro}', 'App\Http\Controllers\constructoraController@ConstructoraGeneral');
Route::get('constructora/api/{accion}', 'App\Http\Controllers\constructoraController@ConstructoraGeneral');
Route::get('constructora/api/{accion}/{parametro}', 'App\Http\Controllers\constructoraController@ConstructoraGeneral');

////////////////////////////////////////////////

/******************************************* */
// ACCIONES SERVICARE INTERIORS
////////////////////////////////////////////////
// Web Services Servicare
Route::post('servicare/api/{accion}', 'App\Http\Controllers\servicareController@servicareGeneral');
Route::post('servicare/api/{accion}/{parametro}', 'App\Http\Controllers\servicareController@servicareGeneral');
Route::get('servicare/api/{accion}', 'App\Http\Controllers\servicareController@servicareGeneral');
Route::get('servicare/api/{accion}/{parametro}', 'App\Http\Controllers\servicareController@servicareGeneral');

////////////////////////////////////////////////

/******************************************* */
// ACCIONES CLUB VILLA LAURA
////////////////////////////////////////////////
// Web Services Servicare
Route::post('villalaura/api/{accion}', 'App\Http\Controllers\villaLauraController@villalauraGeneral');
Route::post('villalaura/api/{accion}/{parametro}', 'App\Http\Controllers\villaLauraController@villalauraGeneral');
Route::get('villalaura/api/{accion}', 'App\Http\Controllers\villaLauraController@villalauraGeneral');
Route::get('villalaura/api/{accion}/{parametro}', 'App\Http\Controllers\villaLauraController@villalauraGeneral');

////////////////////////////////////////////////

/******************************************* */
// ACCIONES SOFTWARE DE PUNTOS DE VENTA
////////////////////////////////////////////////
// Web Services Servicare
Route::post('salespoint/api/{accion}', 'App\Http\Controllers\salespointController@salespointGeneral');
Route::post('salespoint/api/{accion}/{parametro}', 'App\Http\Controllers\salespointController@salespointGeneral');
Route::get('salespoint/api/{accion}', 'App\Http\Controllers\salespointController@salespointGeneral');
Route::get('salespoint/api/{accion}/{parametro}', 'App\Http\Controllers\salespointController@salespointGeneral');

////////////////////////////////////////////////


/******************************************* */
// ACCIONES SERVICARE INTERIORS
////////////////////////////////////////////////
// Web Services Servicare
Route::get('/intuit/auth', [servicareController::class, 'redirectToIntuit'])->name('intuit.redirect');
Route::get('/intuit/callback', [servicareController::class, 'handleIntuitCallback']);

////////////////////////////////////////////////

/******************************************* */
// ACCIONES DE GIMCLOUD MONTACARGAS WILCAR
////////////////////////////////////////////////
// Web Services GIM Cloud Montacargas Wilcar
Route::post('gimcloudwilcar/api/{accion}', 'App\Http\Controllers\gimcloudwilcarController@wilcarGimGeneral');
Route::post('gimcloudwilcar/api/{accion}/{parametro}', 'App\Http\Controllers\gimcloudwilcarController@wilcarGimGeneral');
Route::get('gimcloudwilcar/api/{accion}', 'App\Http\Controllers\gimcloudwilcarController@wilcarGimGeneral');
Route::get('gimcloudwilcar/api/{accion}/{parametro}', 'App\Http\Controllers\gimcloudwilcarController@wilcarGimGeneral');////////////////////////////////////////////////
////////////////////////////////////////////////

Route::get('/debug-sentry', function () {
    throw new Exception('My first Sentry error!');
});



