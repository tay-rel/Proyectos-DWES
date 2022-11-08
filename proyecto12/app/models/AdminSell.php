<?php

class AdminSell
{
    private $db;

    public function __construct()
    {
        $this -> db = Mysqldb::getInstance() -> getDatabase();
    }
    public function detailsProduct( $user_id)
    {
        $sql = 'SELECT * FROM carts WHERE user_id=:user_id AND product_id=:product_id AND date=:date';//AND state=0, comprueba si el producto esta en el carrito
        $query = $this->db->prepare($sql);
        $query->execute([':user_id' => $user_id]);
        return $query->fetchAll(PDO::FETCH_OBJ);

    }

}