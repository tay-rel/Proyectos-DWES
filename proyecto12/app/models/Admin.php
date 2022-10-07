<?php

class Admin
{

    private $model;
    public function __construct()
    {
        $this->db=Mysqldb::getInstance()->getDatabase();
    }
    //creamos una funcion verifyUser que tiene que hacer una consulta a la bbdd
    //SI hay un fetch mas de uno esque hay un error y coge el primero,teniendo en cuenta que $admin es un array

}