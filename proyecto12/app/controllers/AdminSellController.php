<?php

class AdminSellController extends Controller
{

    private $model;

    public function __construct()
    {
        $this->model = $this->model('AdminSell');
    }
    public function index($errors =[])
    {
        $session =new SessionAdmin();
        if ($session->getLogin()) {
            $user_id = $session->getUserId();

            $cart = $this->model->getCart($user_id);
            $data = [
                'titulo' => 'Carrito',
                'menu' => true,
                'user_id' => $user_id,
                'data' => $cart,
                'errors' => $errors,         //pasamos a la vista los errores
            ];
            $this->view('sales/index', $data);
        } else {
            header('location:' . ROOT);
        }
    }
}