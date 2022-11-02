<?php

class Controller
{
    //El modelo recibe un controlador que cambiara el nombre del modelo.
    public function model($model)
    {
        require_once '../app/models/' . $model . '.php';
        return new $model();
    }

    //Los controladores llaman a una vissta porque estan conectadas.
    public function view($view, $data = [])
    {
        if (file_exists('../app/views/' . $view . '.php')) {
            require_once '../app/views/' . $view . '.php';
        } else {
            die('La vista no existe');
        }
    }
}