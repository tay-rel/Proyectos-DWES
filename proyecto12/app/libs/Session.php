<?php

class Session
{
    private $login=false;
    private $user;  //cuando este logueado obtiene user

    public function __construct()
    {
        session_start();        //dic a php que vamos a trabajas con la session
        if(isset($_SESSION['user'])){       //es lo que guardara en la sesion
            //si existe la sesion y esta abierta guarda el valor de user
            $this->user=$_SESSION['user'];
            $this->login=true;
        }else{
            unset($this->user);
            $this->login=false;
        }
    }

    public function login($user)        //habra una sesion para cada usuario logueado
    {
        if ($user){     //almacenamos al usuario las propiedades de la clase
            $this->user=$user;
            $_SESSION['user']=$user;
            $this->login=true;
        }
    }

    public function logout()
    {
        unset($_SESSION['user']);
        unset($this->user);
        session_destroy();
        $this->login=false;
    }

    public  function getLogin()
    {
        return $this->login;
    }

    public function getUser()       //obtine todo el usuario
    {
        return$this->user;
    }
    public function getUserId()
    {
        return $this->user->id;             //solo me devuleve el identificador del usuario
    }

}