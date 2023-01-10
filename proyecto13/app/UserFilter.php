<?php

	namespace App;

	
	use  Illuminate\Support\Carbon;
	use Illuminate\Support\Facades\DB;
	use Psy\Util\Str;
	
	class UserFilter extends QueryFilter
	{
		 protected $aliasses = [
			 'name'=>'first_name',
			 'date' => 'created_at',
		 ];
		 
		 public function getColumnName($alias)
		 {
				return $this ->aliasses[$alias] ?? $alias;
		 }
		public function rules(): array
		{
			return [
				'search' => 'filled',
				'state' => 'in:active,inactive',
				'role' => 'in:admin,user',
				'skills' => 'array|exists:skills,id',
				 'from' =>'date_format:d/m/Y',
					 'to' => 'date_format:d/m/Y',
				 //agregamos nuevas reglas para factorizar el codigo de index
				 'order' => 'in:name,email,date,name-desc,email-desc,date-desc',
				];
		}
		
		public function search($query, $search)
		{
			return $query->where(function ($query) use ($search) {
				$query->whereRaw('CONCAT(first_name, " ", last_name) like ?', "%{$search}%")->orWhere('email', 'like', "%{$search}%")->orWhereHas('team', function ($query) use ($search) {
					$query->where('name', 'like', "%{$search}%");
				});
			});
		}
		
		public function state($query, $state)
		{
			return $query->where('active', $state === 'active');
		}
		 
		 public function skills($query , $skills)
		 {
				//SELECT * FROM users WHERE (SELECT COUNT s.id )
				// FROM skill_user as s WHERE s.user_id =users_id AND s.skill_id IN (4,2))=2
				
				$subquery = DB::table('skill_user AS s')
					->selectRaw('COUNT(s.id)')			//la tabla skill_user sobre la columna id
					->whereColumn('s.user_id', 'users.id')	//la relacion entre tabla pivote y la tabla user
					->whereIn('skill_id', $skills);		//usamos whereIn porque debe ser un array
				
				$query->whereQuery($subquery, count($skills));
		 }
		 
		 public function from($query, $date)		//$date que es la fecha que se esta escribiendo en  el input
		 {
				//Vamos a convertir la fecha en un objeto en una instancia de carbon.
				//Carbon es la libreria que nos permite manejar fechas.
				$date = Carbon::createFromFormat('d/m/Y', $date);
				
				//la query la modificamos con el whereDate donde esto sera la columna created_at
				//el operador mayor es porque significa desde
				$query ->whereDate('created_at', '>=', $date);
				
		 }
		 
		 public function to($query, $date)
		 {
				$date = Carbon::createFromFormat('d/m/Y', $date);
				
				$query ->whereDate('created_at', '<=', $date);
		 }
		 
		 public function order($query, $value)
		 {
				if(\Illuminate\Support\Str::endsWith($value, '-desc')){
					 $query->orderByDesc($this->getColumnName(\Illuminate\Support\Str::substr($value, 0 , -5)));
				}else{
					 $query -> orderBy($this->getColumnName($value));
				}
		 }
		 
	}