<?php

class ShopController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = $this->model('Shop');
    }

    public function index()
    {
        $session=new Session();
        if ($session->getLogin()){  //comprobacion si tenemos la sesion abierta

            //quiero mostrar los productos más vendidos
            $mostSold=$this->model->getMostSold();
            $news=$this->model->getNews();
            $data=[
                'titulo'=>'Bienvenido a la tienda',
                'menu'=> true,
                'subtitle'=>'Articulos mas vendidos',
                'data'=>$mostSold,
                'subtitle2'=>'Articulos nuevos',
                'news'=>$news,
            ];
            $this->view('shop/index', $data);
        }else{
            header('LOCATION' . ROOT);
        }
    }

    public function logout()
    {
        $session = new Session();
        $session->logout();
        header('location:' . ROOT);
    }
    public  function show($id)      //muestra el identificador del producto
    {
        //var_dump($id);
        //a partir del id obtener el producto y desarrolar el getByid
        //obtengo el producto
        $product=$this->model->getProductById($id);
        $data=[
            'titulo'=>'Detalle del producto',
            'menu'=> true,
            'subtitle' => $product->name,
            'errors'=>[],
            'data'=>$product,
        ];
        $this->view('shop/show',$data);
    }
}