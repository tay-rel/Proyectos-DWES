<?php

	namespace App;
	
	use Illuminate\Support\Facades\DB;
	use Illuminate\Support\Facades\Validator;
	use Illuminate\Support\Str;

	class UserQuery extends QueryBuilder
	{

		public function findByEmail($email)
		{
			return $this->whereEmail($email)->first();
		}

	}