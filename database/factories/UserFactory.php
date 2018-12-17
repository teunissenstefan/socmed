<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    $t_gender = $faker->randomElement([1, 2]);
    $gender = 'male';
    if($t_gender==2){
        $gender = 'female';
    }
    return [
        'name' => $faker->firstName($gender),
        'lastname' => $faker->lastName,
        'gender' => $t_gender,
        'birthdate' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];
});
