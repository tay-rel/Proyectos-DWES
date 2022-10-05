<?php

class AdminUser
{
    private $model;

    public function __construct()
    {
        $this->db=Mysqldb::getInstance()->getDatabase();
    }
}