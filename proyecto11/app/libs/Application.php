<?php
/*LA CLASE APLICAION MANEJA LA URL Y LANZA LOS PROCESOS A INCIO.PHP*/
class Application
{
    function __construct()
    {
        print 'Bienvenido a mi tienda';
        $db = Mysqldb::getInstance()->getDatabase();

    }
}