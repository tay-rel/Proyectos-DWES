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
//\Illuminate\Support\Facades\
Route::get('/inicio', function() {
    return 'HOla Mundo';
});

//para acceder a la ruta del usuario debo pasarle por parametro el id para que reciba por get
Route::get('usuarios/{id}', function($id){
   return 'Mostrando detalle del usuario ' . $id;
})->where('id', '[0-9]+');      //crea una condición

//la aplica al final confirmando las anteriores
Route::get('usuarios/nuevo' , function (){
   return 'Creando usuario';
});

//se puede pasar más de un parametro e las rutas
Route::get('saludo/{name}/{nickname?}', function ($name, $nickname=null ){
   //return 'Bienvenido ' . ucfirst($name) . ' tu apodo es' .$nickname;
    if ($nickname) {
        return 'Bienvenido ' . ucfirst($name) . '. Tu apodo es ' . $nickname;
    } else {
        return 'Bienvenido ' . ucfirst($name) . '. No tienes apodo.';
    }
});