<?php

namespace Tests\Feature;

use App\Profession;
use App\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersModuleTest extends TestCase
{
    use RefreshDatabase;        //refresca la bbd automaticamente cada vez que lanza las pruebas
    private $profession;


    public function getValidData(array $custom = [])
    {
        $this->profession = factory(Profession::class)->create();
        return array_merge([           //borra todas las claves que son nulas y las reemplaza
            'name' => 'Pepe',
            'email' => 'pepe@mail.es',
            'password' => '12345678',
            'profession_id' => $this->profession->id,
            'bio' => 'Programador de Laravel y Vue.js',
            'twitter' => 'https://twitter.com/pepe',
        ], $custom);
    }

    /** @test */
    function it_loads_the_users_list_page() //se ejecuta dentro de una transaccion,al principio y al final , terminando todo esto.Se genera un roolback
    {
        //para la prueba, los usuario que estan creados en el test se quedan permanentemente en la bbdd
        //de un test a otro la bbdd debe reiniciarse
        //permite acceder al formulario

        factory(User::class)->create([
            'name' => 'Joel'
        ]);

        factory(User::class)->create([
            'name' => 'Ellie'
        ]);

        $this->get('usuarios')
            ->assertStatus(200)
            ->assertSee('Listado de usuarios')
            ->assertSee('Joel')
            ->assertSee('Ellie');
    }

    //Comprueba si hay un array vacío de usuarios

    /** @test */
    function it_shows_a_default_page_if_the_users_list_is_empty()
    {
        //prueba test

        //para que pase en la bbdd se debe crear otra tabla de bbdd
        $this->get('usuarios?empty')
            ->assertStatus(200)
            ->assertSee('Listado de usuarios')
            ->assertSee('No hay usuarios registrados');
    }

    /** @test */
    function it_displays_the_user_details()
    {
        $user = factory(User::class)->create([
            'name' => 'Carlos Abrisqueta'
        ]);

        $this->get('usuarios/' . $user->id)
            ->assertStatus(200)
            ->assertSee($user->name);
    }

    /** @test */
    function it_loads_the_new_users_page()
    {
        $profession = factory(Profession::class)->create();
        $this->get('usuarios/nuevo')
            ->assertStatus(200)
            ->assertSee('Crear nuevo usuario')
            ->assertViewHas('professions', function ($professions) use ($profession) {
                return $professions->contains($profession);
            });
    }

    /** @test */
    function it_displays_a_404_error_if_the_user_is_not_found()
    {
        $this->get('usuarios/999')
            ->assertStatus(404)
            ->assertSee('Página no encontrada');
    }

    /** @test */
    function it_creates_a_new_user()
    {
        $this->post('usuarios', $this->getValidData())
            ->assertRedirect('usuarios');

        $this->assertCredentials([
            'name' => 'Pepe',
            'email' => 'pepe@mail.es',
            'password' => '12345678',
        ]);

        //los dos nuevos campos pasa los dos campos, para eso debe estar creada la tabla
        $this->assertDatabaseHas('user_profiles',[
            'bio' => 'Programador de Laravel y Vue.js',
            'twitter' => 'https://twitter.com/pepe',
            'user_id' => User::findByEmail('pepe@mail.es')->id,
            'profession_id' => $this->profession->id,
        ]);
    }

    /** @test */
    function the_name_is_required()
    {
        //$this->withoutExceptionHandling();

        $this->from('usuarios/nuevo')
            ->post('usuarios', $this->getValidData([
                'name' => '',
            ]))->assertRedirect('usuarios/nuevo')
            ->assertSessionHasErrors(['name' => 'El campo nombre es obligatorio']);

        $this->assertDatabaseEmpty('users' );
    }

    /** @test */
    function the_email_is_required()
    {
       // $this->withoutExceptionHandling();//mira lo que pasa
        $this->from('usuarios/nuevo')
            ->post('usuarios', $this->getValidData([
                'email' => '',
            ]))->assertRedirect('usuarios/nuevo')            //rediriga a usuario barra nuevo
            ->assertSessionHasErrors(['email' => 'El campo email es obligatorio']);

        $this->assertDatabaseEmpty('users' );
    }

    /** @test */
    function the_password_is_required()
    {
        // $this->withoutExceptionHandling();//mira lo que pasa
        $this->from('usuarios/nuevo')
            ->post('usuarios', $this->getValidData([
                'password' => '',
            ]))->assertRedirect('usuarios/nuevo')            //rediriga a usuario barra nuevo
            ->assertSessionHasErrors(['password' => 'El campo contraseña es obligatorio']);

        $this->assertDatabaseEmpty('users' );
    }

    /** @test */
    function the_bio_is_required()
    {
        // $this->withoutExceptionHandling();
        $this->from('usuarios/nuevo')
            ->post('usuarios', $this->getValidData([
                'bio' => '',
            ]))->assertRedirect('usuarios/nuevo')
            ->assertSessionHasErrors('bio');

        $this->assertDatabaseEmpty('users' );
    }

    /** @test */
    function it_twitter_must_be_valid()
    {
        $this->from('usuarios/nuevo');
        $this->post('usuarios', $this->getValidData([
            'twitter' => 'no-es-valido',
        ]))->assertRedirect('usuarios/nuevo')
            ->assertSessionHasErrors('twitter' );

        $this->assertDatabaseEmpty('users' );
    }

        /** @test */
    function the_email_must_be_valid()
    {
        $this->from('usuarios/nuevo')
            ->post('usuarios', $this->getValidData([
                'email' => 'correo-no-valido',
            ]))->assertRedirect('usuarios/nuevo')            //rediriga a usuario barra nuevo
            ->assertSessionHasErrors('email' ); //se inidica que hay errores con el email

        $this->assertDatabaseEmpty('users' );

    }



    /** @test */
    function the_email_must_be_unique()
    {
       // $this->withoutExceptionHandling();//mira lo que pasa
        //crea un usuario con ese email concreto
        factory(User::class)->create([
            'email'=>'pepe@mail.es'
        ]);

        $this->from('usuarios/nuevo')
            ->post('usuarios', $this->getValidData())
            ->assertRedirect('usuarios/nuevo')             //rediriga a usuario barra nuevo
            ->assertSessionHasErrors('email' );             //se inidica que hay errores con el email

        $this->assertEquals(1, User::count());          //porque el primer usuario ya existe y trata de crear un segundo usuario

    }
    /** @test */
    function the_profession_id_field_is_optional()
    {
        $this->post('usuarios', $this->getValidData([
            'profession_id' => null
        ]))->assertRedirect('usuarios');

        $this->assertCredentials([
            'name' => 'Pepe',
            'email' => 'pepe@mail.es',
            'password' => '12345678',

        ]);

        $this->assertDatabaseHas('user_profiles', [
            'bio' => 'Programador de Laravel y Vue.js',
            'user_id' => User::findByEmail('pepe@mail.es')->id,
            'profession_id' => null,
        ]);
    }

    /** @test */
    function the_profession_id_must_be_valid()
    {
        $this->from('usuarios/nuevo')
            ->post('usuarios', $this->getValidData([
                'profession_id' => '999'
            ]))->assertRedirect('usuarios/nuevo')
            ->assertSessionHasErrors(['profession_id']);

        $this->assertDatabaseEmpty('users');
    }

    /** @test */
    function only_selectable_professions_are_valid()
    {
        $deletedProfession = factory(Profession::class)->create([
            'deleted_at' => now()->format('Y-m-d')
        ]);

        $this->from('usuarios/nuevo')
            ->post('usuarios', $this->getValidData([
                'profession_id' => $deletedProfession->id
            ]))->assertRedirect('usuarios/nuevo')
            ->assertSessionHasErrors(['profession_id']);

        $this->assertDatabaseEmpty('users');
    }

    /** @test */
    function it_loads_the_edit_user_page()
    {
        //se debe ver el formulario con los datos a editar
        //la propiedad heredad que recibe laravel detecta como si no fuese la misma
        $user = factory(User::class)->create();

        $this->get('usuarios/'.$user->id.'/editar')
            ->assertStatus(200)
            ->assertViewIs('users.edit')
            ->assertSee('Editar usuario')
            ->assertViewHas('user', function ($viewUser) use ($user) {
                return $viewUser->id === $user->id;
            });
        //debo enviar a la vista, usamos funcion anonima que podra comprobar los ids de ambos usuarios y no que compruebe los objetos de manera directa.
    }

    /** @test */
    function it_updates_a_user()
        {
            $user = factory(User::class)->create();
            $this->put('usuarios/'.$user->id, [//put=indica que debe actualizar un recurso de la aplicacion
                    'name' => 'Pepe',
                    'email' => 'pepe@mail.es',
                    'password' => '12345678',
            ])->assertRedirect('usuarios/' . $user->id);

            $this->assertCredentials([//una fila que tenga esos elementos,busca las credenciales
                    'name' => 'Pepe',
                    'email' => 'pepe@mail.es',
                    'password' => '12345678',
                ]);

        }

    /** @test */
    function the_name_is_required_when_updating_a_user()
    {
        $user = factory(User::class)->create();
        $this->from('usuarios/'.$user->id.'/editar')
             ->put('usuarios/'.$user->id, [             //put=indica que debe actualizar un recurso de la aplicacion
            'name' => '',
            'email' => 'pepe@mail.es',
            'password' => '12345678',
        ])->assertRedirect('usuarios/' . $user->id . '/editar')
        ->assertSessionHasErrors(['name']);

        $this->assertDatabaseMissing('users',['email' => 'pepe@mail.es']);
    }

    /** @test */
    function the_email_is_required_when_updating_a_user()
    {

   //      $this->withoutExceptionHandling();//mira lo que pasa
        $user = factory(User::class)->create();
        $this->from('usuarios/'.$user->id.'/editar');
        $this->put('usuarios/'.$user->id, [//put=indica que debe actualizar un recurso de la aplicacion
            'name' => 'Pepe',
            'email' => '',
            'password' => '12345678',
        ])->assertRedirect('usuarios/' . $user->id . '/editar')
        ->assertSessionHasErrors(['email']);

        $this->assertDatabaseMissing('users',['name'=>'pepe']);
    }

    /** @test */
    function the_email_must_be_valid_when_updating_a_user()
    {
        $user = factory(User::class)->create();
        $this->from('usuarios/'.$user->id.'/editar');
        $this->put('usuarios/'.$user->id, [
            'name' => 'Pepe',
            'email' => 'correo-no-valido',
            'password' => '12345678',
        ])->assertRedirect('usuarios/' . $user->id . '/editar') //me redirige al propio formulario
            ->assertSessionHasErrors(['email']);

        $this->assertDatabaseMissing('users',['name'=>'pepe']);
    }

    /** @test */
    function the_email_must_be_unique_when_updating_a_user()
    {
        //se debe comprobar que el email es unico

        factory(User::class)->create([
           'email'=>'existing-email@mail.es'
        ]);

        //Investiga cual es el email y para que el usuario modifique algo del email debe ser unico

        $user = factory(User::class)->create([
            'email'=>'pepe@mail.es'             //crea con un nombre aleatorio
        ]);

        $this->from('usuarios/' . $user->id . '/editar');
        $this->put('usuarios/' . $user->id, [
            'name' => 'Pepe',                   //y al modificarlo el nombre sea pepe
            'email' => 'existing-email@mail.es',
            'password' => '12345678',
        ])->assertRedirect('usuarios/' . $user->id . '/editar') //me redirige al propio formulario
        ->assertSessionHasErrors(['email']);

        $this->assertDatabaseMissing('users',['name'=>'pepe']);

    }

    /** @test */
    function the_password_is_optional_when_updating_a_user()
    {
        //LA contraseña es opcinal la puedo cambiar o no.
        //Si se envia la cadena vacia , la encripta y la guarda.

        $oldPassword = 'CLAVE_VIEJA';
        $user = factory(User::class)->create([
            'password'=>bcrypt($oldPassword),       //crea un usuario cuya contraseña es clave vieja
        ]);

        $this->from('usuarios/'.$user->id.'/editar')
        ->put('usuarios/'.$user->id, [
            'name' => 'Pepe',
            'email' => 'pepe@mail.es',
            //si la envio vacia no debe darte error y debe redirigir a la vista show .
            'password' => '',
        ])->assertRedirect('usuarios/' . $user->id); //me redirige al propio formulario

        $this->assertCredentials([
            'name' => 'Pepe',
            'email' => 'pepe@mail.es',
           'password' => $oldPassword,      //sino envia la contraseña mantiene  la anterior
        ]);
    }

    /** @test */
    function the_user_email_can_stay_the_same_when_updating_a_user()
    {
        //Se pide el email

        $user = factory(User::class)->create([
            'email'=> 'pepe@mail.es',       //crea un usuario cuya contraseña es clave vieja
        ]);

        $this->from('usuarios/'.$user->id.'/editar')
            ->put('usuarios/'.$user->id, [
                'name' => 'Pepe',
                'email' => 'pepe@mail.es',
                //si la envio vacia no debe darte error y debe redirigir a la vista show .
                'password' => '12345678',
            ])->assertRedirect('usuarios/' . $user->id ); //me redirige al propio formulario

        $this->assertDatabaseHas('users', [
            'name' => 'Pepe',
            'email' => 'pepe@mail.es',
        ]);
    }

    /** @test */
    function it_deletes_A_user()
    {
        //$this->withoutExceptionHandling();
        $user = factory(User::class)->create();

        $this->delete('usuarios/' . $user->id)
            ->assertRedirect('usuarios');

        $this->assertDatabaseMissing('users',[
           'id'=>$user->id,
        ]);

        $this->assertDatabaseEmpty('users' );
    }
    /** @test */
    function the_twitter_field_is_optional()
    {
        $this->withoutExceptionHandling();
        $this->post('usuarios', $this->getValidData([
            'twitter' => null
        ]))->assertRedirect('usuarios');

        $this->assertCredentials([
            'name' => 'Pepe',
            'email' => 'pepe@mail.es',
            'password' => '12345678',
        ]);

        $this->assertDatabaseHas('user_profiles', [
            'bio' => 'Programador de Laravel y Vue.js',
            'twitter' => null,
            'user_id' => User::findByEmail('pepe@mail.es')->id,
        ]);
    }

}
