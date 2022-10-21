<?php

class SearchController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = $this->model('Search');
    }
    public function products()          //coge todo lo que viene del formulario que le pasa a la bbdd
    {

        $search = $_POST['search'] ?? '';                                //recibimos lo que hay en el input, como es requerido algo sera enviado
                                                //a hacer= aqui se debe validar lo que se coge del formulario.APlicar el trim a la hora de hacer la busqueda
        if($search != ''){                                             //como no se puede confirmar que este campo venga con datos se debe validar en la parte del servidor
            //si el campo lleva algo se hace la busqueda
            $dataSearch=$this->model->getProducts($search);                 //le pasamos la semilla de lo que queremos buscar

            $data = [
                'titulo'=>'Buscador de productos',
                'subtitle'=> 'Resultado de la busqueda',
                'data'=>$dataSearch,
                'menu'=>true,
            ];
            $this->view('search/search',$data);
        }else{
            header('location' . ROOT);          //SI NO VIENE NADA se le redirecciona a la raiz , ROOT si estaba logueado lo llevaba a shop y sino lo lleva al login
        }
    }
}