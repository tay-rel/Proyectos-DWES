<?php

class AdminProduct
{
    private $db;

    public function __construct()
    {
        $this->db = Mysqldb::getInstance()->getDatabase();
    }

    public function getProducts()
    {
        $sql = 'SELECT * FROM products WHERE deleted=0';
        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function getConfig($type)
    {
        $sql = 'SELECT * FROM config WHERE type=:type ORDER BY value';
        $query = $this->db->prepare($sql);
        $query->execute([':type' => $type]);

        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    public function getCatalogue(){
        $sql = 'SELECT id, name, type FROM products WHERE deleted=0 AND status!=0 ORDER BY type, name';
        $query=$this->db->prepare($sql);
        $query->execute();
        return $query ->fetchAll(PDO::FETCH_OBJ);
    }
    public function createProduct($data)
    {
        $sql = 'INSERT INTO products(type, name, description, price, discount, send, image, published, relation1, relation2, relation3, mostSold, new, status, deleted, create_at, updated_at, deleted_at, author, publisher, pages, people, objetives, necesites) 
                VALUES (:type, :name, :description, :price, :discount, :send, :image, :published, :relation1, :relation2, :relation3, :mostSold, :new, :status, :deleted, :create_at, :updated_at, :deleted_at, :author, :publisher, :pages, :people, :objetives, :necesites)';

        $params = [
            ':type' => $data['type'],
            ':name' => $data['name'],
            ':description' => $data['description'],
            ':price' => $data['price'],
            ':discount' => $data['discount'],
            ':send' => $data['send'],
            ':image' => $data['image'],
            ':published' => $data['published'],
            ':relation1' => $data['relation1'],
            ':relation2' => $data['relation2'],
            ':relation3' => $data['relation3'],
            ':mostSold' => $data['mostSold'],
            ':new' => $data['new'],
            ':status' => $data['status'],
            ':deleted' => 0,
            ':create_at' => date('Y-m-d H:i:s'),
            ':updated_at' => null,
            ':deleted_at' => null,
            ':author' => $data['author'],
            ':publisher' => $data['publisher'],
            ':pages' => $data['pages'],
            ':people' => $data['people'],
            ':objetives' => $data['objetives'],
            ':necesites' => $data['necesites']
        ];

        $query = $this->db->prepare($sql);

        return $query->execute($params);
    }

    public  function getProductById($id){
        $sql='SELECT * FROM products WHERE id=:id';

        $query=$this->db->prepare();
        $query->execute([':id' =>$id]);
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function updateProduct($data)
    {
        //actualizare todos los campos ,sino han actualizado no quiero actualizar nada si no me pasan la imagen

        $errors=[];
        $sql = 'UPDATE  products SET (type, name, description, price, discount, send, image, published, relation1, relation2, relation3, mostSold, new, status, deleted, create_at, updated_at, deleted_at, author, publisher, pages, people, objetives, necesites) 
                VALUES (:type, :name, :description, :price, :discount, :send, :image, :published, :relation1, :relation2, :relation3, :mostSold, :new, :status, :deleted, :create_at, :updated_at, :deleted_at, :author, :publisher, :pages, :people, :objetives, :necesites)';

        $params = [
            ':type' => $data['type'],
            ':name' => $data['name'],
            ':description' => $data['description'],
            ':price' => $data['price'],
            ':discount' => $data['discount'],
            ':send' => $data['send'],
            ':image' => $data['image'],
            ':published' => $data['published'],
            ':relation1' => $data['relation1'],
            ':relation2' => $data['relation2'],
            ':relation3' => $data['relation3'],
            ':mostSold' => $data['mostSold'],
            ':new' => $data['new'],
            ':status' => $data['status'],
            ':deleted' => 0,
            ':create_at' => date('Y-m-d H:i:s'),
            ':updated_at' => null,
            ':deleted_at' => null,
            ':author' => $data['author'],
            ':publisher' => $data['publisher'],
            ':pages' => $data['pages'],
            ':people' => $data['people'],
            ':objetives' => $data['objetives'],
            ':necesites' => $data['necesites']
        ];
//NOS PREGUNTAMOS SI LA IMAGEN SE HA RECIBIDO O NO

     if($data['image']){
         //añado a la imagen sino me mandan la imagen no lo añado
         $sql.=', image=:image';
         //parametrizamos
         $params[':image']=$data['image'];//añado una nueva clave con su valor
     }
     //independientemente de que me añada el campo concateno

        $sql .=' WHERE id:=id';

        $query = $this->db->prepare($sql);
        if($query->execute($params)){
            array_push($errors,'El error al modificar el producto');
        }
        return $errors;
    }

    public function delete($id)
    {
        $errors=[];
        $sql='UPDATE products SET deleted=:deleted, deleted_at=:deleted_at WHERE id=:id';
        $params=[
            ':id'=>$id,
            ':deleted'=>1,
            ':deleted'=> date(),//poner fecha


        ];
        $query=$this->db->prepare($sql);
        if($query->execute($params)){
            array_push($errors,'Error al borrar el producto');
        }
        return $errors;
    }
}