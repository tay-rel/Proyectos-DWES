<?php

class Search
{
    private $db;
    public  function __construct()
    {
        $this->db=Mysqldb::getInstance()->getDatabase();
    }
    public function getProducts($string)
    {
        //esta consulta se puede mejorar
        $sql='SELECT * FROM products WHERE deleted=0 AND (name LIKE :name OR publisher LIKE :publisher OR author LIKE :author OR people LIKE :people OR description LIKE :description)';      //los campos que busquen deben ser aquellos campos que no estan eliminados

        $query = $this->db->prepare($sql);
        //generamos el array de parametros, donde busca por diferentes columns
        $params =[
            ':name'=> '%' . $string .'%',       //se puede hacer de ambas maneras, con este tarde menos
            ':publisher'=> "%{$string}%",           //con esta revisa toda la cadena para ver
            ':author'=> '%' . $string .'%',
            ':people' => '%' . $string .'%',
            ':description'=> '%' . $string .'%',
        ];
        $query->execute($params);
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
}