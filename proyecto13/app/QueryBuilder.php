<?php

namespace App;

use App\Filters\QueryFilter;
use http\Exception\BadMethodCallException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class QueryBuilder extends \Illuminate\Database\Eloquent\Builder
{
	 private $filters;
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
	 
	 public function filterBy(QueryFilter $filters, array $data)
	 {
			$this->filters = $filters;
			
			return $filters->applyTo($this, $data);
	 }
	 
	 public function applyFilters(array $data = null)
	 {
			return $this->filterBy($this->newQueryFilter(), $data ?: request()->all());
	 }
	 
	 public function newQueryFilter()
	 {
			if (method_exists($this->model, 'newQueryFilter')) {
				 return $this->model->newQueryFilter();
			}
			
			if (class_exists($filterClass = '\App\Filters\\' . get_class($this->model). 'Filter')) {
				 return new $filterClass;
			}
			
			throw new BadMethodCallException(
				sprintf('No query filter was found for the model [%s]', get_class($this->model))
			);
	 }
	 
	 public function paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null): LengthAwarePaginator
	 {
			$paginator = parent::paginate($perPage, $columns, $pageName, $page);
			
			if ($this->filters) {
				 $paginator->appends($this->filters->valid());
			}
			
			return $paginator;
	 }
}