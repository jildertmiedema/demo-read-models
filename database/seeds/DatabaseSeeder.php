<?php

use App\BusinessLogic\Catalog\Product;
use App\BusinessLogic\Customers\Customer;
use App\BusinessLogic\Orders\Order;
use App\BusinessLogic\Orders\OrderLine;
use App\BusinessLogic\Sales\Account;
use App\BusinessLogic\Sales\Activity;
use App\BusinessLogic\Sales\Appointment;
use App\BusinessLogic\Sales\Project;
use App\BusinessLogic\Sales\State;
use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * @var \Faker\Generator
     */
    private $faker;

    public function __construct(Faker\Generator $faker)
    {
        $this->faker = $faker;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = $this->faker;
        factory(Order::class, 30)
            ->create()
            ->each(function (Order $order) {
                $lines = factory(OrderLine::class, rand(1, 10))->make();
                $order->lines()->saveMany($lines);
            });

        factory(Customer::class, 30)->create();
        factory(Product::class, 30)->create();
        $projects = [];
        $statesIds = collect(['Contact', 'Prospect', 'Offer', 'Last minute', 'Completed'])
            ->map(function ($name) {
                return State::create([
                    'name' => $name,
                ])->id;
            })
            ->toArray();

        factory(User::class, 2)->create()
            ->each(function (User $user) use ($faker, &$projects) {
                $projects[] = factory(Project::class)->create([
                    'name' => 'Selling ' . $faker->productName,
                    'user_id' => $user->id,
                ]);
            });

        factory(Account::class, 200)->create()
            ->each(function (Account $account) use ($faker, $projects, $statesIds) {
                $project = $faker->randomElement($projects);
                $activity = Activity::create([
                    'project_id' => $project->id,
                    'account_id' => $account->id,
                    'status_id' => $faker->randomElement($statesIds)
                ]);
                factory(Appointment::class)->create([
                    'activity_id' => $activity->id,
                    'user_id' => $project->user_id,
                ]);
            });
    }
}
