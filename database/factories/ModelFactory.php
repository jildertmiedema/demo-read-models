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

class ProductFaker extends \Faker\Provider\Base
{
    protected static $productFormats = [
        '{{material}} {{product}}',
        '{{color}} {{material}} {{product}}',
    ];

    protected static $material = [
        'iron',
        'metal',
        'wooden',
        'leather',
        'rock',
        'cotton',
        'plastic',
    ];

    protected static $color = [
        'blue',
        'green',
        'red',
        'brown',
        'yellow',
    ];

    protected static $product = [
        'shoe',
        'train',
        'car',
        'dog',
        'cat',
    ];

    public function material()
    {
        return static::randomElement(static::$material);
    }

    public function color()
    {
        return static::randomElement(static::$color);
    }

    public function product()
    {
        return static::randomElement(static::$product);
    }

    public function title()
    {
        $format = static::randomElement(static::$productFormats);

        return $this->generator->parse($format);
    }
}
//dd($factory);
$factory->faker->addProvider(new ProductFaker($factory->faker));

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
        'name' => ucfirst($faker->title),
        'description' => implode(" ", $faker->paragraphs),
        'price' => rand(1, 1000) / 100.0,
    ];
});
