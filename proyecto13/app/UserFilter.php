<?php

	namespace App;

	use Illuminate\Support\Facades\DB;
	
	class UserFilter extends QueryFilter
	{

		public function rules(): array
		{
			return [
				'search' => 'filled',
				'state' => 'in:active,inactive',
				'role' => 'in:admin,user',
				'skills' => 'array|exists:skills,id'			//No solo debe existir sino que debe estar en la tabla skill y la columna id
				];
		}
		
		public function filterBySearch($query, $search)
		{
			return $query->where(function ($query) use ($search) {
				$query->whereRaw('CONCAT(first_name, " ", last_name) like ?', "%{$search}%")->orWhere('email', 'like', "%{$search}%")->orWhereHas('team', function ($query) use ($search) {
					$query->where('name', 'like', "%{$search}%");
				});
			});
		}
		
		public function filterByState($query, $state)
		{
			return $query->where('active', $state === 'active');
		}
		 
		 public function filterBySkills($query , $skills)
		 {
				//SELECT * FROM users WHERE (SELECT COUNT s.id )
				// FROM skill_user as s WHERE s.user_id =users_id AND s.skill_id IN (4,2))=2
				
				$subquery = DB::table('skill_user AS s')
					->selectRaw('COUNT(s.id)')			//la tabla skill_user sobre la columna id
					->whereColumn('s.user_id', 'users.id')	//la relacion entre tabla pivote y la tabla user
					->whereIn('skill_id', $skills);		//usamos whereIn porque debe ser un array
				
				$query->whereQuery($subquery, count($skills));
		 }
	}