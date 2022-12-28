<?php

	namespace Tests\Feature\Admin;

	use App\Skill;
	use App\User;
	use Tests\TestCase;
	use Illuminate\Foundation\Testing\WithFaker;
	use Illuminate\Foundation\Testing\RefreshDatabase;

	class FilterUsersTest extends TestCase
	{
        use RefreshDatabase;
		/** @test */
		function filter_users_by_state_active()
		{
            $activeUser = factory(User::class)
                ->create();
            $inactiveUser = factory(User::class)
                ->state('inactive')
                ->create();

			$response = $this->get('usuarios?state=active');

			$response->assertViewCollection('users')
				->contains($activeUser)
				->notContains($inactiveUser);
		}

		/** @test */
		function filter_users_by_state_inactive()
		{
            $activeUser = factory(User::class)
                ->create();
            $inactiveUser = factory(User::class)
                ->state('inactive')
                ->create();

			$response = $this->get('usuarios?state=inactive');

			$response->assertViewCollection('users')
				->contains($inactiveUser)
				->notContains($activeUser);
		}


        /** @test */
        function filter_users_by_role_admin()
        {
            $admin = factory(User::class)->create(['role' => 'admin']);
            $user = factory(User::class)->create(['role' => 'user']);

            $response = $this->get('usuarios?role=admin');

            $response->assertViewCollection('users')
                ->contains($admin)
                ->notContains($user);
        }
        /** @test */
        function filter_users_by_role_user()
        {
            $admin = factory(User::class)->create(['role' => 'admin']);
            $user = factory(User::class)->create(['role' => 'user']);

            $response = $this->get('usuarios?role=user');

            $response->assertViewCollection('users')
                ->contains($user)
                ->notContains($admin);
        }
				
				/** @test */
				function filter_users_by_skills()
				{
					 //Creamos dos habilidades
					 $php = factory(Skill::class)->create(['name' => 'php']);
					 $css = factory(Skill::class)->create(['name' => 'css']);
					 
					 //Se creara tres usuarios
					 
					 $backendDev = factory(User::class)->create();
					 $backendDev -> skills() ->attach($php);         //relacion entre el usuario y la habilidad a traves de skill
					 
					 $frontendDev = factory(User::class)->create();
					 $frontendDev -> skills() ->attach($css);
					 
					 $fullendDev = factory(User::class)->create();
					 $fullendDev -> skills() ->attach([$php -> id, $css -> id]);		//como lo  metemos en un array para ser más eficientes debemos hacerlo a traves del identificador
					 
					 //Lanzamos la petición a traves de get
					 $response =$this ->get("/usuarios?skills[0]={$php -> id}&skills[1]={$css -> id}");
					 $response -> assertStatus(200);
					 
					 //Lo que se reciba se debe comprobar que en la vista la colección que
					 //recibimos contiene al fullstack
					 $response ->assertViewCollection('users')
					 	->contains($fullendDev)
						->notContains($backendDev)
					 ->notContains($frontendDev);
					 
				}
				
		 /** @test */
				function filter_users_created_from_date()
				{
					 $newestUser = factory(User::class)->create([
						 'created_at' => '2020-10-02 12:00:00',
					 ]);
					 $oldestUser = factory(User::class)->create([
						 'created_at' => '2020-09-29 12:00:00',
					 ]);
					 $newUser = factory(User::class)->create([
						 'created_at' => '2020-10-01 00:00:00',
					 ]);
					 $oldUser = factory(User::class)->create([
						 'created_at' => '2020-09-30 23:59:59',
					 ]);
					 $response = $this -> get('/usuarios?from=01/10/2020');
					 
					 $response ->assertOk();
					 
					 $response ->assertViewCollection('users')
							->contains($newUser)
							->contains($newestUser)
							->notContains($oldUser)
						 ->notContains($oldestUser);
				}
				
		 /** @test */
//Esta prueba verifica el otro input de tipo fecha
		 function filter_users_created_to_date()
		 {
				$newestUser = factory(User::class)->create([
					'created_at' => '2020-10-02 12:00:00',
				]);
				$oldestUser = factory(User::class)->create([
					'created_at' => '2020-09-29 12:00:00',
				]);
				$newUser = factory(User::class)->create([
					'created_at' => '2020-10-01 00:00:00',
				]);
				$oldUser = factory(User::class)->create([
					'created_at' => '2020-09-30 23:59:59',
				]);
				$response = $this -> get('/usuarios?to=30/09/2020');
				
				$response ->assertOk();
				
				$response -> assertViewCollection('users')
					->contains($oldestUser)
					->contains($oldUser)
					->notContains($newestUser )
					->notContains($newUser );
		 }
	}