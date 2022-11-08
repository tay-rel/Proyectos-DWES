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
                'titulo' => 'Productos vendidos',
                'menu' => false,
                'admin' => true,
                'subtitle' => 'Productos vendidos de la tienda',
            ];
            $this->view('admin/sales/index', $data);
            //var_dump($data);
        }else{
            header('location:' . ROOT .'admin');
        }
    }

    public function verify()
    {
        $session = new Session();
        $user = $session->getUser();
        $cart = $this->model->detailsProduct($user->id);
        $payment = $_POST['payment'] ?? '';

        $data = [
            'titulo' => 'Carrito | Verificar los datos',
            'menu' => true,
            'payment' => $payment,
            'user' => $user,
            'data' => $cart,
        ];

        $this->view('sales/index', $data);
    }

}