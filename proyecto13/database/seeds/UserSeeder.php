<?php

use App\{Login, Profession, Skill, Team, User};
	use Illuminate\Database\Seeder;

	class UserSeeder extends Seeder
	{
		private $professions;
		private $skills;
		private $teams;

		/**
		 * Run the database seeds.
		 *
		 * @return void
		 */
		public function run()
		{
			$this->fetchRelations();

			$user = $this->createAdmin();

			foreach (range(1, 999) as $i) {
				$this->createRandomUser();
			}
		}

		private function fetchRelations(): void
		{
			$this->professions = Profession::all();
			$this->skills = Skill::all();
			$this->teams = Team::all();
		}

		private function createAdmin()
		{
			$user = User::create([
				'team_id' => $this->teams->firstWhere('name', 'IES Ingeniero')->id,
				'first_name' => 'Pepe',
				'last_name' => 'Pérez',
				'email' => 'pepe@mail.es',
				'password' => bcrypt('123456'),
				'role' => 'admin',
				'created_at' => now(),
				'active' => true,
			]);

			$user->profile()->create([
				'bio' => 'Programador',
				'profession_id' => $this->professions
					->where('title', 'Desarrollador Back-End')
					->first()
					->id,
			]);
			return $user;
		}

		private function createRandomUser(): void
		{
			$user = factory(User::class)->create([
				'team_id' => rand(0, 2) ? null : $this->teams->random()->id,
				'active' => rand(0,3) ? true : false,
				'created_at' =>now() -> subDays(rand(1, 90)),	//se le da un numero aleatorio de dias que habrian sido creados a lo largo de los tres mesess
			
			]);

			$user->skills()->attach($this->skills->random(rand(0, 7)));

			$user->profile()->update([
			'profession_id' => rand(0, 2) ? $this->professions->random()->id : null,
			]);
			
			factory(Login::class)-> times( rand(1,10) ) -> create([
				'user_id' =>$user -> id,
			]);
		}
	}