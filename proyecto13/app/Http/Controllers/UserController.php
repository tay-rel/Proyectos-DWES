<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;//si se debe especificar

class UserController extends Controller
{
    public function index()
    {
        return 'Usuarios';
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