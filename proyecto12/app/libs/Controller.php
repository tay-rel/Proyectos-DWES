<?php

class Controller
{
    /*Cada controlador va trabajar con un modelo que cambiara el nombre del
    modelo.
    A cada controlador hay que relacionarlo con un modelo, por eso el parametro
    de entrada para decir con que modelo trabajar.
    LOa modelos se llaman igua que la tabla pero en singular
    */
    public function model($model)
    {
        require_once '../app/models/' . $model . '.php';
        return new $model();
    }

    /*Cada uno de los controladores llamar
     a una vista porque conectan con la vista.
    Puede a ver varias vistas, si la vista no necesita recibir datos
    se pasara un array(asociativo) que le indica los valores que quiere pasar*/

    public function view($view,$data =[])
    {

        if(file_exists('../app/views/' . $view . '.php')){
            require_once '../app/views/' . $view . '.php';    //si existe el fichero lo añadimos

        }else{
            die('La vista no existe');
        }
    }
}