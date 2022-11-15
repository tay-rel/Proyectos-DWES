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
            'name'=>'Ellie',
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
    function it_loads_the_users_detail_page()
    {
        $this->get('usuarios/5')
            ->assertStatus(200)
            ->assertSee('Mostrando los detalles del usuario #5');
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

}
