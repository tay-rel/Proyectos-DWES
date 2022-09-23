<?php
/*
 *la clase Application maneja la URL y lanzq los procesos
 */
class Application
{
    /*HAce de controlador frontal*/

    private $urlController=null;
    private $urlAction=null;
    private $urlParams=[];
    function __construct()
    {
       $db=Mysqldb::getInstance()->getDataBase();

       $url=$this->separarUrl();        /*Obtendra la url*/
       //1 var_dump($url);         /*Depura la Url*/

        if(! $this->urlController){     /*Controlador =false significa que esta vacio */
            require_once '../app/controllers/loginController.php';
            $page=new loginController();
            $page-index();
        }elseif (file_exists('../app/controllers/'
            . ucfirst($this->urlController)
            . 'Controller.php')){      /*Verifica que el fichero exista si lo hace se incluya*/

            $controller= ucfirst($this->urlController) . 'Controller';
            require_once '/app/controllers/' .$controller . '.php' ;
            $this->urlController=new $controller;
            $this->urlController-index();
        }
    }
    public function separarUrl()
    {
        if($_SERVER['REQUEST_URI']!= '/' )
        {
            $url=trim($_SERVER['REQUEST_URI'], '/');        /*Quita la barra por delante y por detras de la palabra*/
            $url=filter_var($url,FILTER_SANITIZE_URL);          /*ELIMINA CARACTERES QUE NO ESTEN PERMITIDOS EN URL*/
            $url=explode('/',$url);                  /*funciona como un array separa la cadena en un array*/

            //2return $url;

           // $this->urlController= isset($url[0]) ? $url[0] : null;
            $this->urlAction=$url[0] ?? null;       /*A param n quiero pasar 0 ni 1 usamos unset*/
            $this->urlAction=$url[1] ?? null;

            unset($url[0],$url[1]);
            $this->urlParams=array_values($url);
        }
    }
}