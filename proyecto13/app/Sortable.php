<?php

namespace App;

use Illuminate\Support\Arr;

class Sortable
{
	
	 protected $currentUrl;
	 protected $query = [];	//si no tenemos nada el ccual se pase como parametro.
	 
	 public function __construct($currentUrl)
	 {
			$this -> currentUrl = $currentUrl;
	 }
	 
	 public function url($column)
	 {
					if($this ->isSortingBy($column)) {		//ordenamos por la columna
					 return $this -> buildSortableUrl($column . '-desc');	//de forma desc
					}
			
					return $this -> buildSortableUrl($column);	//de forma asc
	 }
	 
	 protected function buildSortableUrl($order)
	 {
			return $this -> currentUrl . '?' . Arr::query(array_merge($this -> query, ['order' => $order]));
	 }
	 
	 protected function isSortingBy($column)
	 {
			return Arr::get($this -> query, 'order') == $column;
	 }
	 public function classes($column)
	 {
				 if ($this ->isSortingBy($column)){
						return 'link-sortable link-sorted-up';
				 }
				
				 if ($this->isSortingBy($column . '-desc')){
						return 'link-sortable link-sorted-down';
				 }
				 
		return 'link-sortable';//me devuelve la columna de la doble flecha
	 }
	 
	 public function appends(array $query)
	 {
			//Esta propiedad almacena los filtros que podrian estar aplicadose ademas
			//del orden y la direccion
			$this ->query =$query;

	 }
	 
}