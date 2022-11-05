<?php

class AdminSell
{
    private $db;

    public function __construct()
    {
        $this -> db = Mysqldb::getInstance() -> getDatabase();
    }
    public function getUsers()
    {
        $sql = 'SELECT * FROM users WHERE deleted = 0';
        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    public function getProductById($id)
    {
        $sql = 'SELECT * FROM products WHERE id=:id';
        $query = $this->db->prepare($sql);
        $query->execute([':id' => $id]);

        return $query->fetch(PDO::FETCH_OBJ);
    }
    public function getProducts()
    {
        $sql = 'SELECT * FROM products WHERE deleted=0';
        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

}