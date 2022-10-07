<?php

class AdminController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = $this->model('Admin');
    }

    public function index()
    {
        $data = [
            'titulo' => 'Administración',
            'menu' => false,
            'data' => [],
        ];

        $this->view('admin/index', $data);//el metodo get es quien me lleva al index
    }

    public function verifyUser()
    {
        //completar el metodo verifyUser
        //$errors=verifyUSer , es un else mas interno verifica si hay un error en la base de datos que es un arary que contenga los posibles errores,sino hay errores devuelve array vacio
        //cuando hay errores de validación
        //cuando hay errores de entrada por get
        //Cuando hay errores como no hay else se sale para mostrar a la misma vista
        //Si las validaciones fallan odo falla
        //si ha habido un fallo habra un arraypush  mostrando el error regresando al index porque entra por metodo post

    }
}