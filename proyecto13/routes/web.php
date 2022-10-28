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
Existe unautoload que la clase que no encuentra lo busca  en la clase config
*/

Route::get('/', function () {
    return view('welcome');
});
