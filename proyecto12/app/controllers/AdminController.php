<?php

class AdminController extends Controller
{
private $model;
public function __construct()
{
    $this->model=$this->model('Admin');
}
public function index()
{
    $data=[
        'titulo' => 'Administracion',
        'menu'   => false,
        'data' =>[],
    ];
    $this->view('admin/index',$data );
 }

 public function verifyUser()
 {
    $data=[
        'titulo' => 'Administracion - Inicio',
        'menu'   => false,
        'admin'=>true,          //esta pagina solo es accesible para admin
        'data' =>[],
    ];
     $this->view('admin/index2',$data );
 }

}