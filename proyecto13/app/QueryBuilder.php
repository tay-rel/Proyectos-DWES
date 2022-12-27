<?php

namespace App;

use Illuminate\Support\Facades\DB;

class QueryBuilder extends \Illuminate\Database\Eloquent\Builder
{
	 //Esta clase es creada para que otros metodos puedan acceder a estos metodos
	 //Porque esta clase extiende de Builder
	 public function whereQuery($subquery, $operator,  $value= null)
	 {
			///	Builder::macro('whereQuery', function ($subquery, $operator, $value){
			//Se debe poder enlazar los parametros en la consulta
			$this->addBinding($subquery->getBindings());
			
			//añade a la consulta de forma de una cadena que lo genera tosql()
			$this->where(DB::raw("({$subquery -> toSql()})"),$operator, $value); 	//hemos extraido la consulta principal la consulta qu esta aparte(primer parametro s espera una cadena de texto)
			
	 }
	 
}