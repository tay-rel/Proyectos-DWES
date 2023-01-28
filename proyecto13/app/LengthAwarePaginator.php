<?php

namespace App;

class LengthAwarePaginator extends \Illuminate\Pagination\LengthAwarePaginator
{
	 //redifinemos esta clase para que utilice nuestra clase.
	 public function parameters()
	 {
			return $this->query;
	 }
}