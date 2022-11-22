<?php

use Faker\Generator as Faker;

//Creo factory que es una factoria de datos
$factory->define(App\Profession::class, function (Faker $faker) {
    //crea personajes falsos y datos falsos
    return [
        'title' =>$faker->sentence(3),
    ];
});
