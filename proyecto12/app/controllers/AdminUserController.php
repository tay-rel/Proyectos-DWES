<?php

class AdminUserController extends Controller
{
    private $model;
    public function __construct()
    {
        $this->model=$this->model('AdminUser');
    }

    public function index()
    {
        $data=[
            'titulo' => 'Administracion de usuarios',
            'menu'   => false,
            'admin'=>true,
            'data' =>[],
        ];
        $this->view('admin/users/index',$data );
    }
    public function create()
    {
        $data=[
            'titulo' => 'Administracion de usuarios-Alta',
            'menu'   => false,
            'admin'=>true,
            'data' =>[],
        ];
        $this->view('admin/users/create',$data );
    }

    public function update()
    {
        print 'modificacion';
    }
    public function delete()
    {
        print 'eliminacion';
    }
}