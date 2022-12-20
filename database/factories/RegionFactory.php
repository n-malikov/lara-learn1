<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Entity\Region::class, function (Faker $faker) {
    // php artisan make:factory RegionFactory
    return [
        'name' => $faker->unique()->city,
        'slug' => $faker->unique()->slug(2),
        'parent_id' => null,
    ];
});
