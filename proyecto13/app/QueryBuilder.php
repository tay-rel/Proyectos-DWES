<?php

namespace App;

use Illuminate\Support\Facades\DB;

class QueryBuilder extends \Illuminate\Database\Eloquent\Builder
{

	 public function whereQuery($subquery, $operator,  $value= null)
	 {
			$this->addBinding($subquery->getBindings());
			
			//añade a la consulta de forma de una cadena que lo genera tosql()
			$this->where(DB::raw("({$subquery -> toSql()})"),$operator, $value); 	//hemos extraido la consulta principal la consulta qu esta aparte(primer parametro s espera una cadena de texto)
			
			return $this;
	 }
	 
	 public function onlyTrashedIf($value)
	 {
			if($value){
				 $this -> onlyTrashed();
			}
			return $this;
			
	 }
	 
}