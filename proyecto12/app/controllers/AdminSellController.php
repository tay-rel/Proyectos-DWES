<?php

class AdminSellController extends Controller
{

    private $model;

    public function __construct()
    {
        $this->model = $this->model('AdminSell');
    }
    public function index()
    {
        $session =new SessionAdmin();
        if($session ->getLogin()){
            $data = [
                'titulo' => 'Productos vendidos de la tienda',
                'menu' => false,
                'admin' => true,
                'subtitle' => 'Productos vendidos de la tienda',
            ];
            $this->view('admin/sales/index', $data);
            var_dump($data);
        }else{

            header('location:' . ROOT .'admin');
        }
    }


}