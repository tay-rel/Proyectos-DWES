<?php

class Login
{
    private $db;

    public function __construct()
    {
        $this->db = Mysqldb::getInstance()->getDatabase();
    }

    public function existsEmail($email)
    {
        $sql = 'SELECT * FROM users WHERE email=:email';
        $query = $this->db->prepare($sql);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->execute();

        return $query->rowCount();
    }

    public function createUser($data)
    {
        $response = false;

        if ( ! $this->existsEmail($data['email'])) {
            // Crear el usuario

            $password = hash_hmac('sha512', $data['password'], ENCRIPTKEY);

            $sql = 'INSERT INTO users(first_name, last_name_1, last_name_2, email, 
                  address, city, state, zipcode, country, password) 
                  VALUES(:first_name, :last_name_1, :last_name_2, :email, 
                  :address, :city, :state, :zipcode, :country, :password)';

            $params = [
                ':first_name' => $data['firstName'],
                ':last_name_1' => $data['lastName1'],
                ':last_name_2' => $data['lastName2'],
                ':email' => $data['email'],
                ':address' => $data['address'],
                ':city' => $data['city'],
                ':state' => $data['state'],
                ':zipcode' => $data['postcode'],
                ':country' => $data['country'],
                ':password' => $password,
            ];

            $query = $this->db->prepare($sql);
            $response = $query->execute($params);

        }

        return $response;
    }
    public function getUserByEmail($email){
        $sql='SELECT *FROM users WHERE email=:email';
        $query=$this->db->prepare($sql);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->execute();
//ya se que existe y devuelve una fila y si no hay nada que extraer devuelve null
        return $query->fetch(PDO::FETCH_OBJ);
    }
    public function sendEmail($email)
    {
       // print 'Enviando email a' . $email;
        $user=$this->getUserByEmail($email);
        $fullName=$user->first_name . ' ' .
            $user->last_name_1 . ' ' .
            $user->last_name_2;        //son los nombre de la bbdd last_name_2 ?? ' ' elimina el segundo apellido(porque esta vacio y concatena una espacio) para el fullname

        $msg=$fullName . ', accede al siguiente enlace para cambiar tu contraseña. <br>';
        $msg .='<a  href="' . ROOT . 'login/changePassword/' .$user->id . '">Cambia tu clave de acceso</a>';          //concatena el enlace el .= concatena
        $headers = 'MIME-version: 1.0\r\n';
        $headers.='Content-type:text/html; charset=UTF-8\r\n';
        $headers .='From: tiendamvc\r\n';
        $headers .='REply-to: administracion@tiendamvc.local';

        $subject="Cambiar contraseña en tiendamvc";

        return mail($email ,$subject,$msg,$headers);    //devuelve true si ha sido enviado y false(si hay un problema de envio) sino ha sido enviado
    }

    public function changePassword($id,$password)
    {
        //1 paso para modificar la contraseña es la contraseña nueva
        $pass = hash_hmac('sha512', $password, ENCRIPTKEY);
        $sql='UPDATE users SET password=:password WHERE id=:id';

        $params=[
            ':id'=>$id,
            ':password'=>$pass,
        ];
        $query = $this->db->prepare($sql);  //preparamos la consulta
        return $query->execute(($params));      //return true =correcto y false =incorrecto
    }

    public function verifyUser($email,$password)
    {
        $errors = [];

        $user = $this->getUserByEmail($email);

        $pass = hash_hmac('sha512', $password, ENCRIPTKEY);

        if (!$user) {
            array_push($errors, 'El usuario no existe en nuestros registros');
        } elseif ($user->password != $pass) {
            array_push($errors, 'La contraseña no es correcta');
        }

        return $errors;
    }

}