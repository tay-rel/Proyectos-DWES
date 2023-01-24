<?php

use App\Profession;//imnporta la clase de modelos
use Illuminate\Database\Seeder;

class ProfessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Profession::create([
            'title' => 'Desarrollador Back-End',
        ]);
        Profession::create([
            'title' => 'Desarrollador Front-End',
        ]);
        Profession::create([
            'title' => 'Diseñador web',
        ]);
    }
}
