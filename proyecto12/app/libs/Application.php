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
        $this->separarUrl();

        if(! $this->urlController){     /*Controlador =false significa que esta vacio */
            require_once '../app/controllers/LoginController.php';
            $page=new LoginController();
            $page->index();
        }elseif (file_exists('../app/controllers/' . ucfirst($this->urlController) . 'Controller.php')){      /*Verifica que el fichero exista si lo hace se incluya*/
            $controller= ucfirst($this->urlController) . 'Controller';
            require_once '../app/controllers/' . $controller . '.php' ;
            $this->urlController=new $controller;       //aqui ya empieza como un objeto del controlador

            if(method_exists($this->urlController, $this->urlAction) && is_callable(array($this->urlController,$this->urlAction) ) ){/*Es si existe y lo puedo llamar*/
                if (!empty($this->urlParams) ){
                    call_user_func_array(array($this->urlController,$this->urlAction),$this->urlParams);      //permite llamar a un metodo de una clase
                }else{
                    $this->urlController->{$this->urlAction}();
                }
            }else{
                /*Añade el controlador por si no tiene metodo*/
                if(strlen($this->urlAction == 0)){//devuelve un entero indicando el numero de caracteres que tiene la cadena
                    $this->urlController->index();
                }else{
                    header('HTTP/1.0 404 Not Found'); //Tratamos el error producido cuando creemos el controlador de error
                }
            }
        }else{
            require_once '../app/controllers/LoginController.php';
            $page=new LoginController();
            $page->index();
        }
    }
    public function separarUrl()
    {
        if($_SERVER['REQUEST_URI']!= '/' ) {
            $url=trim($_SERVER['REQUEST_URI'], '/');        /*Quita la barra por delante y por detras de la palabra*/
            $url=filter_var($url,FILTER_SANITIZE_URL);          /*ELIMINA CARACTERES QUE NO ESTEN PERMITIDOS EN URL*/
            $url=explode('/',$url);                  /*funciona como un array separa la cadena en un array*/

            //2return $url;

            // $this->urlController= isset($url[0]) ? $url[0] : null;
            $this->urlController=$url[0] ?? null;       /*A param n quiero pasar 0 ni 1 usamos unset*/
            $this->urlAction=$url[1] ?? null;

            unset($url[0],$url[1]);
            $this->urlParams=array_values($url);
        }
    }
}