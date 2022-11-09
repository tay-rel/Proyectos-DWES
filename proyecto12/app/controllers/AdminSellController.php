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
        $detalles = $this->model->detailsProduct();  //devuelve el metodo creado en el modelo
        if($session ->getLogin()){
            $data = [
                'titulo' => 'Productos vendidos',
                'menu' => false,
                'admin' => true,
                'carrito'=>$detalles,
            ];
            $this->view('admin/sales/index', $data);
            //var_dump($data);
        }else{
            header('location:' . ROOT .'admin');
        }
    }


}