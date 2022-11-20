<?php

use Faker\Generator as Faker;

$factory->define(App\Profession::class, function (Faker $faker) {
    //crea personajes falsos y datos falsos
    return [
        'title' =>$faker->sentence(3),
    ];
});
