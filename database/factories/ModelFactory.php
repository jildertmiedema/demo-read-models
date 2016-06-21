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

use App\BusinessLogic\Sales\Account;
use App\BusinessLogic\Sales\Appointment;
use App\BusinessLogic\Sales\Project;
use Carbon\Carbon;

$factory->faker->addProvider(new App\Fakers\ProductFaker($factory->faker));

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

$factory->define(App\BusinessLogic\Customers\Customer::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'phone' => $faker->phoneNumber,
        'city' => $faker->city,
        'street_address' => $faker->streetAddress,
    ];
});

$factory->define(App\BusinessLogic\Catalog\Product::class, function (Faker\Generator $faker) {
    return [
        'name' => ucfirst($faker->productName),
        'description' => implode(" ", $faker->paragraphs),
        'price' => rand(1, 1000) / 100.0,
    ];
});

$factory->define(Project::class, function (Faker\Generator $faker) {
    return [
        'name' => ucfirst($faker->productName),
        'user_id' => 1,
    ];
});

$factory->define(Account::class, function (Faker\Generator $faker) {
    return [
        'name' => ucfirst($faker->company),
        'website' => 'http://' . $faker->domainName,
        'phone' => $faker->phoneNumber
    ];
});

$factory->define(Appointment::class, function (Faker\Generator $faker) {
    $time = (rand(1, 5) == 2) ? null : (rand(8, 18) . ':' . rand(0, 3) * 15);

    return [
        'time' => $time,
        'date' => Carbon::now()->addDays($faker->randomElement([-1, 0, 0, 0, 1, 2])),
        'done' => $faker->randomElement([true, false, false, false, false])
    ];
});
