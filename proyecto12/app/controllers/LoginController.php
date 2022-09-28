<?php

class LoginController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model=$this->model('Login');
    }

    public function index()
    {
        $data=[
            'titulo'=> 'Login',
            'menu'=>false,          //false si no quiero que en la vista se va el menu
        ];
        $this->view('login',$data);
    }

    public function olvido()
    {
        //DESARROLLAMOS LA PARTE DE REGISTR DE UN USUARI
    }
    public function registro()
    {

        $errors=[];     //añado los errores
        $dataForm=[];

        //var_dump($_POST);           //solo ve que hay en post
        if($_SERVER['REQUEST_METHOD'] == 'post'){
            //Procesa el formulario,requere los formularios
            //var_dump($_POST);
            $firstName=$_POST['first_name'] ?? ' ' ;
            $lastName_1=$_POST['last_name_1'] ?? ' ' ;
            $lastName_2=$_POST['last_name_2'] ?? ' ' ;
            $email=$_POST['email'] ?? ' ' ;
            $password1 = $_POST['password'] ?? '';
            $password2 = $_POST['password2'] ?? '';
            $address = $_POST['address'] ?? '';
            $city = $_POST['city'] ?? '';
            $state = $_POST['state'] ?? '';
            $postcode = $_POST['postcode'] ?? '';
            $country = $_POST['country'] ?? '';

            //asigno valor al array
            $dataForm=[
                'first_name' => $firstName,
                'last_name_1' => $lastName,
                'last_name_2' => $lastName2,
                'email' => $email,
                'password' => $password1,
                'password2' => $password2,
                'address' => $address,
                'city' => $city,
                'state'=> $state,
                'postcode' => $postcode,
                'country' => $country
            ];

            if($firstName == ''){
                array_push($errors, 'El nombre es obligatorio');
            }
            if($lastName_1 == ''){
                array_push($errors, 'El primer apellido es requerido');
            }
            if($lastName_2 == ''){
                array_push($errors, 'El segundo apellido es requerido');
            }
            if($email == ''){
                array_push($errors, 'El email es requerido');
            }
            if($password1 == ''){
                array_push($errors, 'La contraseña es requerida');
            }
            if($password2 == ''){
                array_push($errors, 'El repetir la contraseña es requerida');
            }
            if($address == ''){
                array_push($errors, 'La dirección es requerida');
            }
            if($city == ''){
                array_push($errors, 'La ciudad es requerida');
            }
            if($state == ''){
                array_push($errors, 'La provincia es requerida');
            }
            if($postcode == ''){
                array_push($errors, 'El código postal es requerido');
            }
            if($country == '') {
                array_push($errors, 'El país es requerido');
            }
            if($password1 != $password2){
                array_push($errors, 'Las contraseñas deben ser iguales');
            }
            if(count($errors) == 0){
                print 'Pasamos a dar de alta al usuario en la bbdd';
            }else{
                var_dump($errors);
            }


            }else{      //cuando quiero acceder al formulario,mostramos el formulario

        }
        $data=[
            'titulo'=> 'Registro',
            'menu'=>false,          //false si no quiero que en la vista se va el menu
        ];
        $this->view('register',$data);
    }
}