<?php
/*
 * Manejo de la base de datos de mysql
 */

class Mysqldb
{
//Datos de la conexion

private $host='mysql';
private $user ='default';
private $pass = 'secret';
private $dbname ='miTiendamvc';

//atributos
private static $instancia =null;    /*Se guarda el objeto de la propia clase*/
private $db=null;

    private function __construct()
    {
        //Contendra dos constatntes de la clase pdo
        $options=[
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
        ];
        try {
            $this->db=new PDO(
             'mysql:host=' . $this->host . ';dbname=' . $this-> dbname,
            $this->user,
            $this->pass,
            $options

            );
        }catch ( PDOException $error){
            exit('La base de datos no tiene acceso');
        }
    }
    public static function getInstance()       /*Genera el patron singleton*/
    {
        if(is_null(self::$instancia)){
            self::$instancia=new Mysqldb();
        }
        return self::$instancia;    /*Si $instancia no es null */
    }

    public function getDatabase()
    {
        return $this->db;
    }
}