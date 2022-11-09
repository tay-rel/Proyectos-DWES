<?php

class AdminSell
{
    private $db;

    public function __construct()
    {
        $this -> db = Mysqldb::getInstance() -> getDatabase();
    }
    public function detailsProduct( )
    {
        $sql = 'SELECT usuario.id AS userId ,usuario.first_name AS userName, productos.id AS productId ,productos.name AS nameProduct, carritos.date AS datePay 
                FROM users usuario 
                INNER JOIN carts AS carritos ON usuario.id=carritos.user_id 
                INNER JOIN products AS productos ON productos.id=carritos.product_id;';
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);

    }

}