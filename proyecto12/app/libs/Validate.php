<?php

class Validate
{
//Es una clase de meter algo de orientacion a objetos donde se metera
// un conjunto de validaciones con metodos donde seran estaticos donde agrupan funciones
//todo lo que se recibe por post es una cadena
        public static function number($string) //:float
        {
            $search=[' ','€','$',','];
            $replace=['','','','',];        //si encontrasmo un espacio blanco sustituimos por una cadena vacia
            //internamente esta funcion actua como un foreach recorre la cadena y devuelve lo que busque
            //$number=//lo que busca,por lo que reemplaza, y donde lo reemplaza
            return str_replace($search,$search,$string);
        }
        public static function date($string)
        {
            //yyy/mm/d datepicker
            //arreglar la fecha cuando no recibe nada
            $date=explode('-',$string);
            if(count($date) == 1){//si no pasa nada es false
                return false;
            }
            //se encontro un errror porque no recibi la fecha tambien en checkdate porque no me pasa la fecha
                return checkdate($date[1],$date[2],$date[0]); //calendario gregoriano-m
        }
        public static function dateDif($string)
        {
            //La fecha de publicación es posterior a la fecha de publicacion donde mano los datos a mañana
           //ambas variables son objeto transformados
            $now=new DateTime();//la hora y fecha donde se ejecuta que es la del servidor
            $date=new DateTime($string);                     //nuestra fecha de publicacin es lo que coje
            //ahora se debe comparar con publis o creat

            return ($date > $now);//compara como cadena de caracteres
        }

        public static function file($string)
        {
            $search = [' ', '*', '!', '@', '?', 'á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú', 'ñ', 'Ñ', 'ü', 'Ü', '¿', '¡'];
            $replace = ['-', '', '', '', '', 'a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U', 'n', 'N', 'u', 'U', '', ''];
            $file = str_replace($search,$replace, $string);

            return $file;
        }
        public static function resizeImage($image,$newWidth)        //
        {
            $file='img/'. $image;
            $info=getimagesize($file);//tengo la imagen en forma de array numerico en la posicion 0 nos encontramos la anchura
            $width=$info[0];
            $heigth=$info[1];
            $type=$info['mime'];

            //mantenemos la proporcin de la imagen
            $factor=$newWidth / $width;
            $newHeight=$factor * $heigth;   //la nueva anchura que ehemos calculado

            $image=imagecreatefromjpeg($file);
            $canvas=imagecreatetruecolor($newWidth,$newHeight);
            imagecopyresampled($canvas, $image, 0,0,0,0,$newWidth, $newHeight,$width, $height);//recibe el tamaño que le pondremos redimencionando la imagen

            imagejpeg($canvas,$file,80);
        }

    public static function text($string)
    {//sustituimos entradas que recibimos
        $search = ['^', 'delete', 'drop', 'truncate', 'exec', 'system'];
        $replace = ['-', 'dele*te', 'dr*op', 'trunca*te', 'ex*ec', 'syst*em'];
        $string = str_replace($search, $replace, $string);
        $string = addslashes(htmlentities($string));
    }

    public static function imageFile($file)
    {
        $imageArray=getimagesize($file);//obtengo el tamaño de la imagen
       //se debe comprobar que la imagen se ha enviado
        $imageType=$imageArray[2];
        return (bool)(in_array($imageType,[IMAGETYPE_JPEG,IMAGETYPE_PNG]));
    }
}