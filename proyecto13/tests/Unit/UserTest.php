<?php

namespace Tests\Unit;

use App\Login;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;//usa nuestra clase

class UserTest extends TestCase
{
	 use RefreshDatabase;
	 
	 //obtenemos la ultima fecha de conexión que tiene el usuario
	 /** @test */
	 function gets_the_last_login_datetime_of_each_user()
	 {
			$joel = factory(User::class)->create(['first_name' => 'Joel']);
			factory(Login::class)->create([
				'user_id' => $joel->id,
				'created_at' => '2022-09-18 12:30:00'
			]);
			factory(Login::class)->create([
				'user_id' => $joel->id,
				'created_at' => '2022-09-18 12:31:00'
			]);
			factory(Login::class)->create([
				'user_id' => $joel->id,
				'created_at' => '2022-09-17 12:31:00'
			]);
			
			$ellie = factory(User::class)->create(['first_name' => 'Ellie']);
			factory(Login::class)->create([
				'user_id' => $ellie->id,
				'created_at' => '2022-09-15 12:00:00'
			]);
			factory(Login::class)->create([
				'user_id' => $ellie->id,
				'created_at' => '2022-09-15 12:01:00'
			]);
			factory(Login::class)->create([
				'user_id' => $ellie->id,
				'created_at' => '2022-09-15 11:59:59'
			]);
			
			//llamamos a todos los usuarios
			$users = User::withLastLogin()->get();
			
			$this->assertInstanceOf(Carbon::class, $users->firstWhere('first_name', 'Joel')->last_login_at);
		 
			//last_login_at, es una propiedad que se va crear sobre la marcha para cada clase
			$this->assertEquals(Carbon::parse('2022-09-18 12:31:00'), $users->firstWhere('first_name', 'Joel')->last_login_at);
			$this->assertEquals(Carbon::parse('2022-09-15 12:01:00'), $users->firstWhere('first_name', 'Ellie')->last_login_at);
			//$this->>asserTrue($users->firstWhere('first_name', 'Ellie')->lastLogin->created_at));
	 }
}
