<?php

namespace App\Http\Controllers;


use App\{Http\Requests\CreateUserRequest, Profession,User, UserProfile};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{

    //SI no tiene usuarios se debe crear un mensaje que explique que no hay usuarios
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
        return view('users.create', [
            'professions' => Profession::orderBy('title', 'ASC')->get()
        ]);
    }

    public function store(CreateUserRequest $request)
    {   $request-> createUser();
        return redirect()->route('users');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(User $user)
    {
        $data = request()->validate([      //obtiene la información que viene del formulario, las convierte en null
            'name' => 'required',
            'email' =>'required|email|unique:users,email,' . $user->id,
            'password'=>'',
        ]);
        if($data['password'] != null){
            $data['password']=bcrypt($data['password']);        //sobreescribe la caena encriptada
        }else{
            unset($data['password']);       //quita de $data , la clave password
        }

        $user->update($data);

        return redirect()->route('user.show', $user);//lleva a ver el usuario cuando se haga los cambios
    }
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users');
    }

}