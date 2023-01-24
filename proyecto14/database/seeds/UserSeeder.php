<?php

use App\Profession;//importado de profession
use App\User;//importado de user
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*$professions = DB::select('SELECT id FROM professions WHERE title="Desarrollador Back-End"');
        $professions = DB::select(
            'SELECT id FROM professions WHERE title=?',
            ['Desarrollador Back-End']
        );
        $profession = DB::table('professions')
            ->select('id')
            ->where('title', 'Desarrollador Back-End')
            ->first();
        $professionId = DB::table('professions')
            ->where('title', 'Desarrollador Back-End')
            ->value('id');
        $professionId = DB::table('professions')
            ->whereTitle('Desarrollador Back-End')
            ->value('id');*/

        //orm =que trabaja a nivel de modelo,sino se usaria el constrctor de consultas
        User::create([
            'name' => 'Pepe Pérez',
            'email' => 'pepe@mail.es',
            'password' => bcrypt('123456'),
            'profession_id' => Profession::whereTitle('Desarrollador Back-End')
                ->value('id')
        ]);

        User::create([
            'name' => 'Ariel mayta',
            'email' => 'ariel@mail.es',
            'password' => bcrypt('123456'),
            'profession_id' => Profession::whereTitle('Desarrollador Back-End')
                ->value('id')
        ]);
    }
}
