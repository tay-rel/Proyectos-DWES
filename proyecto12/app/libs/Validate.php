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
        public static function date($string){
            //yyy/mm/d datepicker
            $date=explode('-',$string);
                return checkdate($date[1],$date[2],$date[0]); //calendario gregoriano-m
        }
        public static function dateDif($string){
            //La fecha de publicación es posterior a la fecha de publicacion donde mano los datos a mañana
           //ambas variables son objeto transformados
            $now=new DateTime();//la hora y fecha donde se ejecuta que es la del servidor
            $date=new DateTime($string);                     //nuestra fecha de publicacin es lo que coje
            //ahora se debe comparar con publis o creat

            return ($date > $now);//compara como cadena de caracteres
        }

        public static function file($string){

        }


}