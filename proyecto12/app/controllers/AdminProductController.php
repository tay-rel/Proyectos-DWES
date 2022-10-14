<?php

class AdminProductController extends Controller
{
<<<<<<< HEAD
=======


>>>>>>> e726dd6c1ff450fc85dfbcecc0fd97a078d68702
    private $model;

    public function __construct()
    {
        $this->model = $this->model('AdminProduct');
    }

    public function index()
    {
<<<<<<< HEAD
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

=======
        $session = new Session();

        if ($session->getLogin()) {

            $products = $this->model->getProducts();
            $type = $this->model->getConfig('productType');

            $data = [
                'titulo' => 'Administración de Productos',
                'menu' => false,
                'admin' => true,
                'type' => $type,
                'products' => $products,
            ];

            $this->view('admin/products/index', $data);

        } else {
            header('location:' . ROOT . 'admin');
        }
    }

    public function create()
    {
        $errors = [];
        $dataForm = [];
        $type = $this->model->getConfig('productType');

        $data = [
            'titulo' => 'Administración de Productos - Alta',
            'menu' => false,
            'admin' => true,
            'type' => $type,
            'errors' => $errors,
            'data' => $dataForm,
        ];

        $this->view('admin/products/create', $data);
    }

    public function update($id)
    {

    }

    public function delete($id)
    {

    }
>>>>>>> e726dd6c1ff450fc85dfbcecc0fd97a078d68702
}