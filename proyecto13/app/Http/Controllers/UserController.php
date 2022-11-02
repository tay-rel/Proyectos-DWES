<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;//si se debe especificar

class UserController extends Controller
{

    //SI no tiene usuarios se deb crear un mensaje que explique que no hay usuarios
    public function index()
    {
        $title = 'Listado de usuarios';

        //La funcion request recibe los datos de petición realizada al servidor desde el cliente.
        //El has pregunta si tiene la clave empty.
       if(request() -> has('empty')){
           $users = [];
       }else{
           $users = ['Joel', 'Ellie', 'Tess', 'Tommy', 'Bill'];
       }
        return view('users.index', compact(
                'title',
                'users'
            )
        );     //para pasarle a la vista dee pasarle un array asociativo donde la clave sera el name de la var['users' => $users, 'title' => $title]    return view('users',compact('title', 'users') );
    }

    public function show($id)
    {
        return view('users.show', compact('id'));
    }

    public function create()
    {
        return 'Creando nuevo usuario';
    }
}