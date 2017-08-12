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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Consultant::class, function (Faker\Generator $faker) {
    $options = \App\Package::all()->random();
    // dd($options->name);
    return [
        'name' => $faker->name,
        "surname"  => $faker->name,
        "company"  => $faker->company,
        'email' => $faker->unique()->safeEmail,
        'country' =>  $faker->company,
        'description' => $faker->realText($maxNbChars = 200, $indexSize = 2),
        "phone_number"  => $faker->phoneNumber,
        "specialises_in"  => $options->name,

    ];
});
