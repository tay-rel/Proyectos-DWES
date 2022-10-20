<?php

class Shop
{
    public function __construct()
    {
        $this->db = Mysqldb::getInstance()->getDatabase();
    }
    public function getMostSold()
    {
        $sql='SELECT * FROM products WHERE mostSold=1 AND deleted=0 LIMIT 8'; //el valor uno se lo asignamos nosotros como admin es fija y ponemos un limite de 8 primeros que aparecena en el index
        $query=$this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }


    public  function getProductById($id){       //para estoe modelo no se reepita debemos añadir un triat
        $sql='SELECT * FROM products WHERE id=:id';

        $query=$this->db->prepare($sql);
        $query->execute([':id' =>$id]);
        return $query->fetch(PDO::FETCH_OBJ);
    }
    public function getNews()
    {
        $sql='SELECT * FROM products WHERE mostSold!=1 AND new=1 deleted=0 LIMIT 8'; //mostsold es distinto de uno para no tenr repetidos
        $query=$this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

}