<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('ValidarLogin','Api\WebServiceController@fncValidarLogin');
Route::get('ListarEspecialistaDia','Api\WebServiceController@fncListarEspecialistasDia');
Route::post('RegistrarCitaUsuario','Api\WebServiceController@fncRegistrarCitaUsuario');
Route::post('TotalCitas','Api\WebServiceController@TotalCitasRestantes');
Route::post('ValidarMedicoAsistencia','Api\WebServiceController@ValidarMedicoAsistencia');