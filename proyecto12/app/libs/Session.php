<?php

class Session
{
    private $login=false;
    private $user;  //cuando este logueado obtiene user
    private $cartTotal;

    public function __construct()
    {
        session_start();        //dic a php que vamos a trabajas con la session
        if(isset($_SESSION['user'])){       //es lo que guardara en la sesion
            //si existe la sesion y esta abierta guarda el valor de user
            $this->user=$_SESSION['user'];
            $this->login=true;
            $_SESSION['cartTotal'] = $this->cartTotal();
            $this->cartTotal =$_SESSION['cartTotal'];

        }else{
            unset($this->user);
            $this->login=false;
        }
    }

    public function login($user)        //habra una sesion para cada usuario logueado
    {
        if ($user){     //almacenamos al usuario las propiedades de la clase
            $this->user=$user;
            $_SESSION['user']=$user;
            $this->login=true;
        }
    }

    public function logout()
    {
        unset($_SESSION['user']);
        unset($this->user);
        session_destroy();
        $this->login=false;
    }

    public  function getLogin()
    {
        return $this->login;
    }

    public function getUser()       //obtine todo el usuario
    {
        return$this->user;
    }
    public function getUserId()
    {
        return $this->user->id;             //solo me devuleve el identificador del usuario
    }
    public function cartTotal()
    {
        //la informacion total se obtiene de la base de datos
        $db = Mysqldb::getInstance()->getDatabase();

        $sql = 'SELECT sum(p.price * c.quantity) - sum(c.discount) + sum(c.send) as total
                FROM carts as c, products as p
                WHERE c.user_id=:user_id AND c.product_id=p.id AND c.state=0';
        $query = $db->prepare($sql);
        $query->execute([':user_id' => $this->getUserId()]);
        $data = $query->fetch(PDO::FETCH_OBJ);

        unset($db); //aliminamos la variable si todo va bien

        return ($data->total ?? 0); //si no hay nada en el carrito me devolvera 0 por eso el nullish
    }
}