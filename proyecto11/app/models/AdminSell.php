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
        $sql = "SELECT c.user_id AS ID, u.first_name AS Nombre , c.product_id AS ID,  GROUP_CONCAT(p.name , ' ') as Producto ,
                p.price AS Precio ,  c.quantity AS Cantidad , c.discount AS Descuento  , c.send AS Envio,( c.quantity * (p.price -c.discount) + c.send) as Total , c.date AS datePay
                FROM carts as c  
                INNER JOIN products as p ON  p.id = c.product_id 
                INNER JOIN users as u on u.id = c.user_id 
                WHERE c.state=1 
                group by c.date;";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);

    }
}