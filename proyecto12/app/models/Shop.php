<?php

class Shop
{
    public function __construct()
    {
        $this->db = Mysqldb::getInstance()->getDatabase();
    }


}