<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    public function profession ()
    {
        //n->1 usuario tiene solo una profesion
        //definimos la relacion a nivel de framework
        //Se relaciona con la clave foranea a traves del segundo parametro
       return $this->belongsTo(Profession::class);
    }
    public function profile ()
    {
        //1->1 usuario tiene solo un perfil
        return $this->hasOne(UserProfile::class);
    }

    public function isAdmin()
    {
        return $this->is_admin;
    }
    public static function findByEmail($email)
    {
        return static::whereEmail($email)->first();
    }

    public static function createUser($data)
    {
        DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
            ]);

            $user->profile()->create([
                'bio' => $data['bio'],
                'twitter' => $data['twitter'],
            ]);
        });
    }
}
