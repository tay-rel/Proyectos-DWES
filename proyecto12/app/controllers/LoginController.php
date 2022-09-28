<?php

class LoginController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model=$this->model('Login');
    }

    public function index()
    {
        $data=[
            'titulo'=> 'Login',
            'menu'=>false,          //false si no quiero que en la vista se va el menu
        ];
        $this->view('login',$data);
    }

    public function olvido()
    {
        //DESARROLLAMOS LA PARTE DE REGISTR DE UN USUARI
    }
    public function registro()
    {
        $data=[
            'titulo'=> 'Registro',
            'menu'=>false,          //false si no quiero que en la vista se va el menu
        ];
        $this->view('register',$data);
    }
}