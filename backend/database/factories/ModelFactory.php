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

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
    ];
});

/**
 * Factory definition for model App\Models\Service.
 */
$factory->define(App\Models\Service::class, function ($faker) {
    return [
        // Fields here
    ];
});

/**
 * Factory definition for model App\Handle.
 */
$factory->define(App\Handle::class, function ($faker) {
    return [
        'provider_id' => $faker->key,
    ];
});
