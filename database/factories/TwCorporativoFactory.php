<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\TwCorporativo;
use Faker\Generator as Faker;

$factory->define(TwCorporativo::class, function (Faker $faker) {
    return [
        'S_NombreCorto' => $faker->userName,
        'S_nombreCompleto' => $faker->name,
        'S_LogoURL' => $faker->url,
        'S_DBName' => $faker->name,
        'S_DBPassword' => $faker->password,
        'S_SystemUrl' => $faker->url,
        'S_Activo' => $faker->randomDigit,
        'D_FechaIncorporacion'=> $faker->dateTime,
        'tw_usuarios_id' => factory(\App\TwUsuario::class)
    ];
});
