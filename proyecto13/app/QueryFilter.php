<?php

	namespace App;

	use Illuminate\Support\Facades\Validator;
	use Illuminate\Support\Str;

	abstract class QueryFilter
	{
		private $valid;		//se guarda en la url aquello que solo ha sido validado
		abstract  public function  rules(): array;

		public function applyTo($query, array $filters)
		{
			$rules = $this->rules();

			$validator = Validator::make(array_intersect_key($filters, $rules), $rules);

			$this->valid = $validator->valid();		//guarda todo aquello que ha sido validado

			foreach (($this->valid) as $name => $value) {
				$this->applyFilters($query, $name, $value);
			}

			return $query;
		}

		private function applyFilters($query,$name, $value): void
		{
			$method = 'filterBy' . Str::studly($name);

			if (method_exists($this, $method)) {
				$this->{$method}($query,$value);	//llamamos a un metodo que modificara la consulta.
			} else {
				$query->where($name, $value); //con el where modificamos directamente la consulta.
			}
		}

		public function valid()
		{
			return $this->valid;
		}
	}