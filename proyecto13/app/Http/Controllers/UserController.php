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

    public function show(User $user)
    {

        if ($user == null) {
            return response()->view('errors.404', [], 404);
        }

        return view('users.show', compact('user'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store()
    {
        $data = request()->validate([
            'name' => 'required',
            'email' =>'required|email|unique:users,email',
            'password'=>'required',
        ], [
            'name.required' => 'El campo nombre es obligatorio',
            'email.required' => 'El campo email es obligatorio',
            'password.required' => 'El campo password es obligatorio'
        ]);
        //llama al metodo create
        //dd($data);//sirve para ver que recibe
        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        return redirect()->route('users');
    }
    public function edit(User $user)
    {
        //se debe dar un id , para localizarlo
        //se usa el binding
            return view('users.edit', compact('user'));
    }

    public function update(User $user)
    {
        $data=request()->all();
        $data['password'] =bcrypt($data['password']);

        return redirect()->route('user.show',$user);//lleva a ver el usuario cuando se haga los cambios
    }
}