<?php
/*MANEJO DE BBDD DE MYSQL*/
class Mysqldb
{
    private $host='mysql';
    private $user='default';
    private $pass='secret';
    private $dbname='miTiendamvc';

    private static $instancia= null;
    private $db= null;
}