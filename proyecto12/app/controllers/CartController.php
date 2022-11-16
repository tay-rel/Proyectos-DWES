<?php

class CartController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = $this->model('Cart');
    }
    public function index($errors = [])
    {
        //comprobamos que estamos logueados
        $session=new Session();
        if($session -> getLogin()){
            //guarda el resultado
            $user_id = $session->getUserId();
            //obtenemos el carrito para el usuario
            $cart = $this ->model->getCart($user_id);
            //generamos array de datos que pasamos a la vista

            $data = [
                'titulo' =>'Carrito',
                'menu' =>true,
                'user_id' =>$user_id,
                'data'=>$cart,
                'errors'=> $errors,         //pasamos a la vista los errores
            ];
            $this->view('carts/index', $data);
        }else{
            header('location:' . ROOT);
        }
    }

    public function addProduct($product_id, $user_id)
    {
        $errors = [];
        //llama al modelo
        if ($this->model->verifyProduct($product_id, $user_id) == false) {//debo comprobar que esta en el carrito !
            if ($this->model->addProduct($product_id, $user_id) == false) {
                array_push($errors, 'Error al insertar el producto en el carrito');
            }
        }
        $this->index($errors);  //recibe el array de errores el metodo index
    }
    public function update()
    {
        if(isset($_POST['rows']) && isset($_POST['user_id'])){
            $errors=[];
            $rows =$_POST['rows'];      //envia dos filas para cada tabla debemos procesar cada tabla
            $user_id = $_POST['user_id'];

            for ($i = 0; $i < $rows; $i++ ){       //recorrera las tres filas
                $product_id = $_POST['i'. $i];           //asi obtengo el producto
                $quantity =$_POST['c' . $i];
                //actualizar la fila correspondiente del producto
                if( ! $this ->model->update($user_id, $product_id, $quantity)){
                    array_push($errors,'Error al actualizar el producto');
                }//cuando termina el for actualiza todo lo que se ha modificado en el carrito
            }
            $this->index($errors);
        }
    }
    public function delete($product, $user)
    {
        $errors = [];

        if( ! $this->model->delete($product, $user)) {
            array_push($errors, 'Error al borrar el registro del carrito');
        }

        $this->index($errors);
    }
    public function checkout()  //cuando entras a pagar
    {
        //se necesita que todas las sesiones esten iniciadas
        $session = new Session();

        if ($session->getLogin()) {

            $user = $session->getUser();

            $data = [
                'titulo' => 'Carrito | Datos de envío',
                'subtitle' => 'Checkout | Verificar dirección de envío',
                'menu' => true,
                'data' => $user,
            ];
            $this->view('carts/address', $data);
        } else {
           /* $data = [
                'titulo' => 'Carrito | Checkout',
                'subtitle' => 'Checkout | Iniciar sesion',
                'menu' => true
            ];

            $this->view('carts/checkout', $data);*/
            header('location:' . ROOT);
        }
    }
    public function paymentmode()
    {   //llega al metodo de pago si va bien.
        $session = new Session();

        if ($session->getLogin()) {
            $data = [
                'titulo' => 'Carrito | Forma de pago',
                'subtitle' => 'Checkout | Forma de pago',
                'menu' => true,
            ];
            $this->view('carts/paymentmode', $data);
        }else{
            header('location:' . ROOT);
        }


    }
    public function verify()
    {
        $session = new Session();
      if($session->getLogin()){
          $user = $session->getUser();
          $cart = $this->model->getCart($user->id);
          $payment = $_POST['payment'] ?? '';

          $data = [
              'titulo' => 'Carrito | Verificar los datos',
              'menu' => true,
              'payment' => $payment,
              'user' => $user,
              'data' => $cart,
          ];

          $this->view('carts/verify', $data);
      }else{
          header('location:' . ROOT);
      }
    }

    public function thanks()
    {
        $session = new Session();
        $user = $session ->getUser();

        //variable para obtener el producto del carrito
        $prices= $this->model->getProductPrices($user->id);
        foreach ($prices as $price){
            $this->model->updateProductPrice($price->product_id,$user->id,$price->price);
        }

        //necesiatariamos la condicional si esta dado de alta

       if ($session->getLogin()){
           if($this->model->closeCart($user->id, 1)){     //pasamos el identificador del usuario y se pasa el nuevo estado, si ha ido bien muestro la vista posible=!
               $data = [
                   'titulo' => 'Carrito | GRacias por su compra',
                   'data' => $user,
                   'menu' => true,

               ];
           }else {
               $data = [
                   'titulo' => 'Error en la actualizacion del carrito',
                   'menu' => false,
                   'subtitle' =>'Error en la actualizacion del carrito',
                   'text' =>   'Por favor , comuniquese con el sopoprte',
                   'color' => 'alert-danger',
                   'url'  => 'login',
                   'colorButton' => 'btn-danger',
                   'textBUtton'=>'Regresar',
               ];
               $this->view('mensaje', $data);
           }

           $this ->view('carts/thanks' , $data);
       }else{
           header('location:' . ROOT);
       }
    }
   /* public function createNewAddress()
    {

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Procesamos la información recibida del formulario
            $firstName = $_POST['first_name'] ?? '';
            $lastName1 = $_POST['last_name_1'] ?? '';
            $lastName2 = $_POST['last_name_2'] ?? '';
            $email = $_POST['email'] ?? '';
            $address = $_POST['address'] ?? '';
            $city = $_POST['city'] ?? '';
            $province = $_POST['province'] ?? '';
            $postcode = $_POST['postcode'] ?? '';
            $country = $_POST['country'] ?? '';

            $dataForm = [
                'firstName' => $firstName,
                'lastName1' => $lastName1,
                'lastName2' => $lastName2,
                'email' => $email,
                'address' => $address,
                'city' => $city,
                'province' => $province,
                'postcode' => $postcode,
                'country' => $country
            ];
        }
        $this->view('carts/address',$dataForm);
    }*/
}