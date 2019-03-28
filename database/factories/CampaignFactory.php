<?php

use Faker\Generator as Faker;

$factory->define(App\Campaign::class, function (Faker $faker) {
    return [
        //
        'name' => $faker->name,
        'start_date' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'end_date' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'active' => true,
        'client_id' => 1,
    ];
});
