<?php

class Cart
{
    private $db;
    public  function __construct()
    {
        $this->db=Mysqldb::getInstance()->getDatabase();
    }

    public function verifyProduct($product_id,$user_id)
    {
        $sql = 'SELECT * FROM carts WHERE product_id=:product_id AND user_id=:user_id';
        $query = $this->db->prepare($sql);
        $params = [
            ':product_id' => $product_id,
            ':user_id' => $user_id,
        ];
        $query->execute($params);
        return $query->rowCount();        //devuelve el numero de filas que se encuentra

    }
    public function addProduct($product_id,$user_id)
    {                                                                       //se debe mirar el estado del producto si ,puede realizarse
        $sql = 'SELECT * FROM products WHERE id=:id';          //guarda el precio de la venta,precio,descuento ,envio.Saco los datos de ese producto y cuando genere la linea se guarda
        $query = $this->db->prepare($sql);
        $query->execute([':id' => $product_id]);       //se envia un array de un solo elemento
        $product = $query->fetch(PDO::FETCH_OBJ);


        $sql2 = 'INSERT INTO carts(state, user_id, product_id, quantity, discount, send, date)
                 VALUES (:state, :user_id, :product_id, :quantity, :discount, :send, :date)';
        $query2 = $this->db->prepare($sql2);
        $params2 = [
            ':state' => 0,
            ':user_id' => $user_id,
            ':product_id' => $product_id,
            ':quantity' => 1,
            ':discount' => $product->discount,
            ':send' => $product->send,
            ':date' => date('Y-m-d H:i:s'),
        ];
        $query2->execute($params2);
        return $query2 ->rowCount();//numero de filas afectamos si inserta 1 y si no 0
    }

    public function getCart($user_id)
    {
        $sql = 'SELECT c.user_id as user, c.product_id as product, c.quantity as quantity, 
                c.send as send, c.discount as discount, p.price as price, p.image as image,
                p.description as description, p.name as name
                FROM carts as c, products as p
                WHERE c.user_id=:user_id AND state=0 AND c.product_id=p.id';

        $query = $this->db->prepare($sql);
        $query->execute([':user_id' => $user_id]);

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function update($user , $product , $quantity)
    {

        $sql = 'UPDATE carts SET quantity=:quantity WHERE user_id=:user_id AND product_id=:product_id';
        $query = $this->db->prepare($sql);
        $params = [
            ':user_id' => $user,
            ':product_id' => $product,
            ':quantity' => $quantity,
        ];

        return $query->execute($params);
    }
    public function delete($product, $user)
    {
            //borra cosas que hay en el carrito devolvera un true si bien y false si mal
        $sql = 'DELETE FROM carts WHERE user_id=:user_id AND product_id=:product_id';
        $query = $this->db->prepare($sql);
        $params = [
            ':user_id' => $user,
            ':product_id' => $product,
        ];
        return $query->execute($params);
    }
}