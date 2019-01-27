<?php

use Faker\Generator as Faker;
use App\Consumer;

$factory->define(Consumer::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'age' => $faker->numberBetween(14, 99),
        'city' => $faker->randomElement(Consumer::getAvailableCities()),
    ];
});
