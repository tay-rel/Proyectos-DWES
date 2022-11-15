<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

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
        'password', 'remember_token',
    ];

    public function profession ()
    {
        //n->1 usuario tiene solo una profesion
        //definimos la relacion a nivel de framework
        //Se relaciona con la clave foranea a traves del segundo parametro
       return $this->belongsTo(\Profession::class);
    }

    public function isAdmin()
    {
        return $this->email ==='Pepe Perez';
    }
}
