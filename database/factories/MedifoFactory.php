<?php

use Faker\Generator as Faker;

$factory->define(App\Medico::class, function (Faker $faker) {
    return [
        'Especialista_Id' => $faker->numberBetween(1,10),
        'Nombre' => $faker->name,
        'Apellido' => $faker->lastName,
        'DNI' => $faker->numberBetween(10000000,99999999),
        'Email' => $faker->safeEmail
    ];
});
