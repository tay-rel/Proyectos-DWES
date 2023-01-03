<?php

namespace App;

use Illuminate\Support\Arr;

class Sortable
{
	 protected $currentColumn;
	 protected $currentDirection;
	 protected $currentUrl;
	 
	 public function __construct($currentUrl)
	 {
			$this -> currentUrl = $currentUrl;
	 }
	 
	 public function setCurrentOrder ($column, $direction = 'asc')
	 {
			$this -> currentColumn = $column;	//En la propiedad almacenamos el orden de la columna que estamos considerando.
			$this -> currentDirection =$direction;
	 }
	 
	 //El metodo conforma una URL
	 //que nos devuelve un array en formato de cosulta
	 public function url($column)
	 {
					if($this ->isSortingBy($column, 'asc')) {
					 return $this -> buildSortableUrl($column, 'desc');
					}
			
					return $this -> buildSortableUrl($column, 'asc');
	 }
	 
	 protected function buildSortableUrl($column, $direction = 'asc')
	 {
			return $this -> currentUrl . '?' . Arr::query(['order' => $column, 'direction' => $direction]);
	 }
	 
	 protected function isSortingBy($column, $direction)
	 {
			return $this-> currentColumn == $column && $this -> currentDirection == $direction;
	 }
	 public function classes($column)
	 {
				 if ($this ->isSortingBy($column, 'asc')){
						return 'link-sortable link-sorted-up';
				 }
				
				 if ($this->isSortingBy($column, 'desc')){
						return 'link-sortable link-sorted-down';
				 }
				 
		return 'link-sortable';//me devuelve la columna de la doble flecha
	 }
	 
}