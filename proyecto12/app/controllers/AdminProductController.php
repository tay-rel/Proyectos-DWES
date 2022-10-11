<?php

class AdminProductController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = $this->model('AdminProduct');
    }

    public function index()
    {
        $session= new Session();
        if($session->getLogin()){
            $products = $this->model ->getProducts();
        }else{
            header('location: ' . ROOT . 'admin');
        }
    }
    public function create()
    {

    }
    public function update()
    {

    }
    public function delete()
    {

    }

}