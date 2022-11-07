<?php

class AdminSell
{
    private $db;

    public function __construct()
    {
        $this -> db = Mysqldb::getInstance() -> getDatabase();
    }
   public function getSell($user_id)
   {
      //$sql ='SELECT * FROM user_id, product_id, date';
       $sql = 'SELECT * FROM  c.user_id as user, c.product_id as product, 
                c.send as send, p.price as price, p.image as image,
                p.description as description, p.name as name
                FROM carts as c, products as p
                WHERE c.user_id=:user_id AND state=0 AND c.product_id=p.id';
       $query =  $this->db->prepare($sql);
       $query->execute([':user_id' => $user_id]);
       return $query->fetchAll(PDO::FETCH_OBJ);
   }

}