<?php

class ShopController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = $this->model('Shop');
    }

    public function index()
    {
        $session=new Session();
        if ($session->getLogin()){
            $data=[
                'titulo'=>'Bienvenido a la tienda',
                'menu'=>true,
                'subtitle'=>'Bienvenido a la tienda',
            ];
            $this->view('shop/index', $data);
        }else{
            header('LOCATION' . ROOT);
        }

    }

    public function logout()
    {
        $session = new Session();
        $session->logout();
        header('location:' . ROOT);
    }
}