<?php

use Faker\Generator as Faker;

$factory->define(App\Post::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'summary' => $faker->paragraph,
        'detail' => $faker->paragraph,
        'created_by' => 1,
        //'published_at' => new \MongoDB\BSON\UTCDateTime,
        //'published_at' => null,
    ];
});
