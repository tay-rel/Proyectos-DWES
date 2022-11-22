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

}
