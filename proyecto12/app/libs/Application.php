<?php
/*
 *la clase Application maneja la URL y lanzq los procesos
 */
class Application
{
    function __construct()
    {
       $db=Mysqldb::getInstance()->getDataBase();
        print 'Bienvenido a mi tienda virtual';
    }

}