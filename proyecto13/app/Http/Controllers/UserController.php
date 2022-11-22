<?php

namespace App\Http\Controllers;


use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//si se debe especificar

class UserController extends Controller
{

    //SI no tiene usuarios se deb crear un mensaje que explique que no hay usuarios
    public function index()
    {
        //1-$users =DB::table('users')->get();
        $users = User::all();    // 2- de todos los usuarios lo quiero todo
        $title = 'Listado de usuarios';

        //La funcion request recibe los datos de petición realizada al servidor desde el cliente.
        //El has pregunta si tiene la clave empty.

        /* if(request() -> has('empty')){
               $users = [];
           }else{
               $users = ['Joel', 'Ellie', 'Tess', 'Tommy', 'Bill'];
           }*/

        //   ->with('users', User::all())
        //  ->with('title','Listado de usuarios');//-3

        return view('users.index', compact(
                'title',
                'users'
            )
        );     //para pasarle a la vista dee pasarle un array asociativo donde la clave sera el name de la var['users' => $users, 'title' => $title]    return view('users',compact('title', 'users') );
    }

    public function show($id)
    {
        $user = User::find($id);

        return view('users.show', compact('user'));
    }

    public function create()
    {
        return 'Creando nuevo usuario';
    }
}