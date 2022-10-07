<?php

class AdminShopController extends Controller
{
    private $model;
    public function __construct()
    {
        $this->model=$this->model('AdminShop');
    }

    //creamos el index para el menu del adminitrador
}