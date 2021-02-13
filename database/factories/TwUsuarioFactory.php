<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\TwUsuario;
use Faker\Generator as Faker;

$factory->define(TwUsuario::class, function (Faker $faker) {
    return [
        'username' => $faker->unique()->userName,
        'email' => $faker->unique()->safeEmail,
        'S_Nombre' => $faker->firstName,
        'S_Apellidos' => $faker->lastName,
        'S_FotoPerfilUrl' => $faker->url,
        'S_Activo' => $faker->randomDigit,
        'password' => bcrypt('12345'),
    ];
});
