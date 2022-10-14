<?php

class Admin
{

    private $db;
    public function __construct()
    {
        $this->db = Mysqldb::getInstance()->getDatabase();
    }

    public function verifyUser($data)
    {
        $errors = [];

        $password = hash_hmac('sha512', $data['password'], ENCRIPTKEY);

        $sql = 'SELECT * FROM admins WHERE email=:email';
        $query = $this->db->prepare($sql);
        $query->bindParam(':email', $data['user'], PDO::PARAM_STR);
        $query->execute();
        $admins = $query->fetchAll(PDO::FETCH_OBJ);

        if ( ! $admins ) {
            array_push($errors, 'El usuario no existe en nuestros registros');
        } elseif (count($admins) > 1) {
            array_push($errors, 'El correo electrónico está duplicado');
        } elseif ($password != $admins[0]->password) {
            array_push($errors, 'La clave de acceso no es correcta');
<<<<<<< HEAD
        }elseif($admins[0] -> status == 0){
            array_push($errors,'El usuario esta desactivado');//si genera un arrore no se loguea
        }elseif($admins[0] -> deleted == 1){
            array_push($errors,'El usuario no existe en nuestros registros');
=======
        } elseif ($admins[0]->status == 0) {
            array_push($errors, 'El usuario está desactivado');
        } elseif ($admins[0]->deleted == 1) {
            array_push($errors, 'El usuario no existe en nuestros registros');
>>>>>>> e726dd6c1ff450fc85dfbcecc0fd97a078d68702
        } else {
            $sql2 = 'UPDATE admins SET login_at=:login WHERE id=:id';
            $query2 = $this->db->prepare($sql2);
            $params = [
                ':login' => date('Y-m-d H:i:s'),
                ':id' => $admins[0]->id,
            ];
            if ( ! $query2->execute($params)) {
                array_push($errors, 'Error al modificar la fecha de último acceso');
            }
        }
        return $errors;
    }
}