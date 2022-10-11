<?php

class AdminUserController extends Controller
{
    private $model;

    public function __construct()
    {
        $this -> model = $this->model('AdminUser');
    }

    public function index()
    {
        $session= new Session();
           if($session -> getLogin()){
               $users=$this -> model ->getUsers();
               $data = [
                   'titulo' => 'Administración de Usuarios',
                   'menu' => false,
                   'admin' => true,
                   'users' => $users,
               ];
               $this->view('admin/users/index', $data);
           }else{
               header('location:' . ROOT . 'admin');
           }

    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $errors = [];

            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password1 = $_POST['password1'] ?? '';
            $password2 = $_POST['password2'] ?? '';

            $dataForm = [
                'name' => $name,
                'email' => $email,
                'password1' => $password1,
            ];

            if (empty($name)) {
                array_push($errors, 'El nombre de usuario es requerido');
            }
            if (empty($email)) {
                array_push($errors, 'El correo electrónico de usuario es requerido');
            }
            if (empty($password1)) {
                array_push($errors, 'La clave de acceso es requerida');
            }
            if (empty($password2)) {
                array_push($errors, 'La verificación de clave es requerida');
            }
            if ($password1 != $password2) {
                array_push($errors, 'Las claves no coinciden');
            }

            if ( ! $errors) {

                if ($this -> model -> createAdminUser($dataForm)) {
                    header("location:" . ROOT . 'AdminUser');
                } else {

                    $data = [
                        'titulo' => 'Error en la creación de un usuario administrador',
                        'menu' => false,
                        'errors' => [],
                        'subtitle' => 'Error al crear un nuevo usuario administrador',
                        'text' => 'Se ha producido un error durante el proceso de creación de un usuario administrador',
                        'color' => 'alert-danger',
                        'url' => 'adminuser',
                        'colorButton' => 'btn-danger',
                        'textButton' => 'Volver',
                    ];
                    $this->view('mensaje', $data);

                }

            } else {

                $data = [
                    'titulo' => 'Administración de Usuarios - Alta',
                    'menu' => false,
                    'admin' => true,
                    'errors' => $errors,
                    'data' => $dataForm,
                ];

                $this->view('admin/users/create', $data);

            }

        } else {

            $data = [
                'titulo' => 'Administración de Usuarios - Alta',
                'menu' => false,
                'admin' => true,
                'data' => [],
            ];

            $this->view('admin/users/create', $data);

        }
    }
    public function update($id)
    {
        $errors=[];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $name=$_POST['name'] ?? '';
            $email=$_POST['email'] ?? '';
            $password1=$_POST['password1'] ?? '';
            $password2=$_POST['password2'] ?? '';
            $status=$_POST['status'] ?? '';

            if ($name == '') {
                array_push($errors, 'El nombre es requerido');
            }
            if ($email == '') {
                array_push($errors, 'El email es requerido');
            }
            if ($status == '') {
                array_push($errors, 'Selecciona el estado');
            }
            if(!empty($password1) || !empty($password2)){//si entro de esta condional me han enviado una contraseña u otra .
                if($password1 != $password2){//si me envian una u otra
                    array_push($errors, 'Las contraseña no coinciden');//si no pasan esta validacin es porque deben rellenar las dos
                }
                if(! $errors){          //devuelve estos datos
                    $data = [
                        'id' =>$id,
                        'name' => $name,
                        'email' => $email,
                        'password1' => $password1,
                        'status' => $status,
                    ];
                    $errors=$this->model->setUser($data);                //llamo al modelo
                    if(! $errors){                                      //regresa al listado de los admins
                        header('location: '. ROOT .'AdminUser');//termina la ejecucion del metodo

                    }
                }
            }

        }
        $user = $this->model->getUserById($id);                             //si es por get ibtenemos los usuarios
        $status = $this->model->getConfig('adminStatus');

        $data = [
            'titulo' => 'Administración de Usuarios - Editar',
            'menu' => false,
            'admin' => true,
            'data' => $user,
            'status' => $status,
            'errors'=>$errors,
        ];

        $this->view('admin/users/update', $data);

    }

    public function delete($id)
    {
        $errors=[];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $errors=$this->model->delete($id);
        if(! $errors){
            header('location: '. ROOT .'AdminUser');
        }

        }
        $user = $this->model->getUserById($id);                             //si es por get ibtenemos los usuarios
        $status = $this->model->getConfig('adminStatus');               //datos del status

        $data = [
            'titulo' => 'Administración de Usuarios - Eliminar',
            'menu' => false,
            'admin' => true,
            'data' => $user,
            'status' => $status,
            'errors'=>$errors,
        ];

        $this->view('admin/users/delete', $data);
    }
}