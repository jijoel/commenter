<?php

use Faker\Generator as Faker;

$factory->define(App\Comment::class, function (Faker $faker) {
    return [
        'parent_id' => null,
        'name' => $faker->name,
        'comment' => $faker->paragraphs(3, true),
    ];
});
