<?php

class AdminUser
{
    private $db;

    public function __construct()
    {
        $this->db=Mysqldb::getInstance()->getDatabase();
    }
    public function createAdminUser($data)
    {
        $response = false;

        if ( ! $this -> existsEmail($data['email'])) {

            $password = hash_hmac('sha512', $data['password'], ENCRIPTKEY);

            $sql = 'INSERT INTO admins(name, email, password, status, deleted, login_at, created_at, updated_at, deleted_at) 
                VALUES (:name, :email, :password, :status, :deleted, :login_at, :created_at, :updated_at, :deleted_at)';
            $params = [
                ':name' => $data['name'],
                ':email' => $data['email'],
                ':password' => $password,
                ':status' => 1,
                ':deleted' => 0,
                ':login_at' => null,
                ':created_at' => date('Y-m-d H:i:s'),
                ':updated_at' => null,
                ':deleted_at' => null,
            ];
            $query = $this->db->prepare($sql);
            $response = $query->execute($params);

        }

        return $response;
    }

    public function existsEmail($email)
    {
        $sql = 'SELECT * FROM admins WHERE email=:email';
        $query = $this->db->prepare($sql);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->execute();

        return $query->rowCount();
    }

    //genera una funcion getUser que es parecida a otras es where porque no este borrado por deleted que el 0 es falso y 1 true
    public function getUsers()
    {
        $sql = 'SELECT * FROM admins WHERE deleted = 0';
        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_OBJ);  //devuelve como un objeto
    }

    public function getUserById($id)
    {
        $sql = 'SELECT * FROM admins WHERE id=:id';
        $query = $this->db->prepare($sql);
        $query->execute([':id' => $id]);

        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function getConfig($type)
    {
        $sql = 'SELECT * FROM config WHERE type=:type ORDER BY value DESC';
        $query = $this->db->prepare($sql);
        $query->execute([':type' => $type]);

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * @param PDO|null $db
     */
    public function setUser($user)                          //verifica si envia o no contrasñea
    {
     $errors=[];

     if($user['password']){//si me envian la cotraseña
         //se envio contraseña
         $sql='UPDATE admins SET  name=:name, email=: , password=:password, status=:status,
         update_at=:update_at WHERE id=:id';
         $pass=hash_hmac('sha512',$user['password'],ENCRIPTKEY);
         $params=[
             ':id'=>$user['id'],
             ':name'=>$user['name'],
             ':email'=>$user['email'],
             ':password'=>$pass,
             ':status'=>$user['status'],
             ':update_at'=>date('Y-m-d H:i:s'),
         ];
     }else{//si no me envian la contraseña
         $sql='UPDATE admins SET  name=:name, email=: , password=:password, status=:status,
         update_at=:update_at WHERE id=:id';
         $params=[
             ':id'=>$user['id'],
             ':name'=>$user['name'],
             ':email'=>$user['email'],
             ':status'=>$user['status'],
             ':update_at'=>date('Y-m-d H:i:s'),
         ];
     }
     $query=$this->db ->prepare($sql);
     if(! $query -> execute($params)){
         array_push($errors, 'Erro al modificar el usuario administrador');
     }
     return $errors;
    }

}