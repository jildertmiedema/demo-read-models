<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

use Carbon\Carbon;

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\BusinessLogic\Orders\Order::class, function (Faker\Generator $faker) {
    return [
        'customer_name' => $faker->name,
        'date' => function () {
            return Carbon::now()->subDays(rand(0, 30));
        },
    ];
});

$factory->define(App\BusinessLogic\Orders\OrderLine::class, function (Faker\Generator $faker) {
    return [
        'description' => $faker->opera,
        'piece_price' => rand(1, 1000) / 100.0,
        'amount' => rand(1, 10),
    ];
});
