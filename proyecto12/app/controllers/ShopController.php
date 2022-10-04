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
                'menu'=>false,
            ];
            $this->view('shop/index');
        }else{
            header('location:' . ROOT);
        }

    }
}