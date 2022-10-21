<?php

class CartController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = $this->model('Cart');
    }
    public function index()
    {

    }

    public function addProduct($product_id, $user_id)
    {
        $errors = [];
        //llama al modelo
        if ($this->model->verifyProduct($product_id, $user_id) == false) {//debo comprobar que esta en el carrito !
            if ($this->model->addProduct($product_id, $user_id) == false) {
                array_push($errors, 'Error al insertar el producto en el carrito');
            }
        }
        $this->index();
    }
}