<?php

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/configuracionCuenta', 'HomeController@configuracionCuenta')->name('configuracionCuenta');
Route::post('/editarUsuarioAutenticado', 'HomeController@editarUsuarioAutenticado');
Route::post('/subirCarnet', 'HomeController@subirCarnet');
Route::get('/obtenerInformacionCarnets', 'HomeController@obtenerInformacionCarnets');
Route::post('/cambioDeEstado', 'HomeController@cambioDeEstado');
Route::get('/comprobarSiHaSubidoFoto', 'HomeController@comprobarSiHaSubidoFoto');
