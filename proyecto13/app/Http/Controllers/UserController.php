<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;//si se debe especificar

class UserController extends Controller
{
    public function index()
    {
        $title = 'Listado de usuarios';
        $users = ['s',
            'd',
            'h',
            's',
            ];
        return view('users')
        ->with(compact('title', 'users') );        //para pasarle a la vista dee pasarle un array asociativo donde la clave sera el name de la var['users' => $users, 'title' => $title]    return view('users',compact('title', 'users') );
    }

    public function show($id)
    {
        return 'Mostrando detalles del usuario: ' . $id;
    }

    public function create()
    {
        return 'Creando nuevo usuario';
    }
}