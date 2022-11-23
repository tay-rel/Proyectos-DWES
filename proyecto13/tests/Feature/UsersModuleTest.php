<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersModuleTest extends TestCase
{
    use RefreshDatabase;        //refresca la bbd automaticamente cada vez que lanza las pruebas

    /**
     * @test
     */
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

    /**
     * @test
     */
    function it_shows_a_default_page_if_the_users_list_is_empty()
    {
        //prueba test
        DB::table();

        //para que pase en la bbdd se debe crear otra tabla de bbdd
        $this->get('usuarios?empty')
            ->assertStatus(200)
            ->assertSee('Listado de usuarios')
            ->assertSee('No hay usuarios registrados');
    }

    /**
     * @test
     */
    function it_displays_the_user_details()
    {
        $user = factory(User::class)->create([
            'name' => 'Carlos Abrisqueta'
        ]);

        $this->get('usuarios/' . $user->id)
            ->assertStatus(200)
            ->assertSee($user->name);
    }

    /**
     * @test
     */
    function it_loads_the_new_users_page()
    {
        $this->get('usuarios/nuevo')
            ->assertStatus(200)
            ->assertSee('Creando nuevo usuario');
    }

    /**
     * @test
     */
    function it_displays_a_404_error_if_the_user_is_not_found()
    {
        $this->get('usuarios/999')
            ->assertStatus(404)
            ->assertSee('Página no encontrada');
    }

    /**
     * @test
     */
    function it_creates_a_new_user()
    {
        $this->post('usuarios', [
            'name' => 'Pepe',
            'email' => 'pepe@mail.es',
            'password' => '12345678',
        ])->assertRedirect('usuarios');

        $this->assertCredentials([
            'name' => 'Pepe',
            'email' => 'pepe@mail.es',
            'password' => '12345678',
        ]);
    }

    /**
     * @test
     */
    function the_name_is_required()
    {
        //$this->withoutExceptionHandling();

        $this->from('usuarios/nuevo')
            ->post('usuarios', [
                'name' => '',
                'email' => 'pepe@mail.es',
                'password' => '12345678',
            ])->assertRedirect('usuarios/nuevo')
            ->assertSessionHasErrors(['name' => 'El campo nombre es obligatorio']);

        $this->assertEquals(0, User::count());
    }

    /**
     * @test
     */
    function the_email_is_required()
    {
       // $this->withoutExceptionHandling();//mira lo que pasa
        $this->from('usuarios/nuevo')
            ->post('usuarios', [
                'name' => 'Pepe',
                'email' => '',
                'password' => '12345678',
            ])->assertRedirect('usuarios/nuevo')            //rediriga a usuario barra nuevo
            ->assertSessionHasErrors(['email' => 'El campo email es obligatorio']);

        $this->assertEquals(0, User::count());
    }

    /**
     * @test
     */
    function the_password_is_required()
    {
        // $this->withoutExceptionHandling();//mira lo que pasa
        $this->from('usuarios/nuevo')
            ->post('usuarios', [
                'name' => 'Pepe',
                'email' => 'pepe@mail.es',
                'password' => '',
            ])->assertRedirect('usuarios/nuevo')            //rediriga a usuario barra nuevo
            ->assertSessionHasErrors(['password' => 'El campo contraseña es obligatorio']);

        $this->assertEquals(0, User::count());
    }
    /**
     * @test
     */
    function the_email_must_be_valid()
    {
        $this->from('usuarios/nuevo')
            ->post('usuarios', [
                'name' => 'Pepe',
                'email' => 'correo-no-valido',
                'password' => '12345678',
            ])->assertRedirect('usuarios/nuevo')            //rediriga a usuario barra nuevo
            ->assertSessionHasErrors('email' ); //se inidica que hay errores con el email

        $this->assertEquals(0, User::count());

    }
    /**
     * @test
     */
    function the_email_must_be_unique()
    {
       // $this->withoutExceptionHandling();//mira lo que pasa
        //crea un usuario con ese email concreto
        factory(User::class)->create([
            'email'=>'pepe@mail.es'
        ]);

        $this->from('usuarios/nuevo')
            ->post('usuarios', [
                'name' => 'Pepe',
                'email' => 'pepe@mail.es',
                'password' => '12345678',
            ])->assertRedirect('usuarios/nuevo')            //rediriga a usuario barra nuevo
            ->assertSessionHasErrors('email' ); //se inidica que hay errores con el email

        $this->assertEquals(1, User::count());    //porque el primer usuario ya existe y trata de crear un segundo usuario

    }

    /**
     * @test
     */
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
            });   //debo enviar a la vista, usamos funcion anonima que podra comprobar los ids de ambos usuarios y no que compruebe los objetos de manera directa.
    }
        /**
         * @test
         */
        function it_updates_a_user()
        {
            $user = factory(User::class)->create();
                $this->put('usuario/'.$user->id,[//put=indica que debe actualizar un recurso de la aplicacion
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

}
