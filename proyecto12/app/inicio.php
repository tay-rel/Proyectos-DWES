<?php

ini_set('display_errors',1);
//constantes iniciales:Se define aqui porque estar como una variable global porque lo necesitaremos en otros archivos
define('ROOT', DIRECTORY_SEPARATOR);
define('APP', ROOT .'app' . DIRECTORY_SEPARATOR);   //  /app/
define('ENCRIPTIKEY','elperrodesanroque');      //PUEDE CAMBIAR LA CLAVEDE LA ENCRIPTACION


// Carga las clases iniciales

require_once ('libs/Mysqldb.php');
require_once ('libs/Controller.php');
require_once('libs/Application.php');   //contenedor de clases=libreria