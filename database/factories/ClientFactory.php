<?php

use Faker\Generator as Faker;

$factory->define(App\Client::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'ruc' => getRuc(),
        'description' => $faker->sentence,
    ];
});

function getRuc(){
    $fake = \Faker\Factory::create();
    $ruc = (string) $fake->randomNumber($nbDigits = 5);
    $ruc .= (string) $fake->randomNumber($nbDigits = 6);
    return $ruc;
}