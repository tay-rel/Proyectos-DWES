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

//listar usuarios
Route::get('usuarios' , 'UserController@index')->name('users');       //cuando escriba /usuarios debe llmar al metodo index

//para acceder a la ruta del usuario debo pasarle por parametro el id para que reciba por get
Route::get('usuarios/{user}','UserController@show')
    ->where('id', '[0-9]+')
    ->name('user.show');

//la aplica al final confirmando las anteriores
Route::get('usuarios/nuevo', 'UserController@create' )->name('user.create');

//se puede pasar más de un parametro e las rutas
Route::get('saludo/{name}/{nickname?}', 'WelcomeUserController');