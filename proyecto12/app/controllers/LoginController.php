<?php

class LoginController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = $this->model('Login');
    }

    public function index()
    {
        $data = [
            'titulo' => 'Login',
            'menu'   => false,
        ];

        $this->view('login', $data);
    }

    public function olvido()
    {
        $errors=[];
        if($_SERVER['REQUEST_METHOD'] != 'POST') {
            $data=[
                'titulo'=>'Bienvenido',
                'menu'=>false,
                'errors'=>[],
                'subtitle'=>'¿Olvidaste la contraseña?'
            ];
        }else{
           // print'estoy dentro';
            $email = $_POST['email'] ?? '';
            if ($email == '') {
                array_push($errors, 'El email es requerido');
            }
            if (!filter_var($email,FILTER_VALIDATE_EMAIL)){
                array_push($errors, 'El correo electronico no es valido');
            }
            if (count($errors)==0){
                //comprueba si esta en la bbdd
                if(!$this->model->existsEmail($email)){
                    array_push($errors,'El correo electronico no existe en ela base de datos');
                }else{
                    //enviar un email si existe en la bbd
                    $this->model->sendEmail($email);
                }

            }
            if(count($errors)>0){
                //regresa a la vista anterior Olvido
                $data=[
                    'titulo'=>'OLvido de la contraseña',
                    'menu'=>false,
                    'errors'=>$errors,
                    'subtitle'=>'¿Olvidaste la contraseña?'
                ];
                $this->view('olvido',$data);
            }
        }


        $this->view('olvido',$data);
    }

    public function registro()
    {
        $errors = [];
        $dataForm = [];

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Procesamos la información recibida del formulario
            $firstName = $_POST['first_name'] ?? '';
            $lastName1 = $_POST['last_name_1'] ?? '';
            $lastName2 = $_POST['last_name_2'] ?? '';
            $email = $_POST['email'] ?? '';
            $password1 = $_POST['password'] ?? '';
            $password2 = $_POST['password2'] ?? '';
            $address = $_POST['address'] ?? '';
            $city = $_POST['city'] ?? '';
            $state = $_POST['state'] ?? '';
            $postcode = $_POST['postcode'] ?? '';
            $country = $_POST['country'] ?? '';

            $dataForm = [
                'firstName' => $firstName,
                'lastName1' => $lastName1,
                'lastName2' => $lastName2,
                'email' 	=> $email,
                'password'  => $password1,
                'address'	=> $address,
                'city'		=> $city,
                'state'		=> $state,
                'postcode'	=> $postcode,
                'country'	=> $country
            ];

            if ($firstName == '') {
                array_push($errors, 'El nombre es requerido');
            }
            if ($lastName1 == '') {
                array_push($errors, 'El primer apellido es requerido');
            }
            if ($lastName2 == '') {
                array_push($errors, 'El segundo apellido es requerido');
            }
            if ($email == '') {
                array_push($errors, 'El email es requerido');
            }
            if ($password1 == '') {
                array_push($errors, 'La contraseña es requerido');
            }
            if ($password2 == '') {
                array_push($errors, 'Repetir contraseña es requerido');
            }
            if ($address == '') {
                array_push($errors, 'La dirección es requerida');
            }
            if ($city == '') {
                array_push($errors, 'La ciudad es requerida');
            }
            if ($state == '') {
                array_push($errors, 'La provincia es requerida');
            }
            if ($postcode == '') {
                array_push($errors, 'El código postal es requerido');
            }
            if ($country == '') {
                array_push($errors, 'El país es requerido');
            }
            if ($password1 != $password2) {
                array_push($errors, 'Las contraseñas deben ser iguales');
            }

            if (count($errors) == 0) {
                //print 'Pasamos a dar de alta al usuario en la BD';
                if($this->model->createUser($dataForm)){
                    $data=[
                        'titulo'=>'Bienvenido',
                        'menu'=>false,
                        'errors'=>[],
                        'subtitle'=>'Bienvenido/a a nuestra tienda online',
                        'text'=>'Gracias por su registro',
                        'color'=>'alert-success',
                        'url'=>'menu',  //menu controller que va a mensaje [url]
                        'colorButton'=>'btn-success',
                        'textButton'=>'Acceder',

                    ];
                    $this->view('mensaje',$data);
                }else{
                    $data=[
                        'titulo'=>'Error',
                        'menu'=>false,
                        'errors'=>[],
                        'subtitle'=>'Error en el proceso de registro.Revise los datos',
                        'text'=>'Probablemente el correo ya exista',
                        'color'=>'alert-danger',
                        'url'=>'login',  //menu controller que va a mensaje [url]
                        'colorButton'=>'btn-danger',
                        'textButton'=>'Regresar',

                    ];
                    $this->view('mensaje',$data);
                }
            } else {
                $data = [
                    'titulo' => 'Registro',
                    'menu'   => false,
                    'errors' => $errors,
                    'dataForm' => $dataForm
                ];

                $this->view('register', $data);
            }
        } else {
            // Mostramos el formulario
            $data = [
                'titulo' => 'Registro',
                'menu'   => false,
            ];

            $this->view('register', $data);
        }
    }
}