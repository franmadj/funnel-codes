<?php

use Faker\Generator as Faker;
use App\User;
use App\Tag;

$factory->define(App\Tag::class, function (Faker $faker) {
    $users = User::find([1]);
    
    return [
        'name' => $faker->word,
        'color' => $faker->hexcolor,
        'user_id' => function () use ($users) {
            if ($users->count()) {
                return $users->random()->id;
            }
            return 1;
        },
        
    ];
});
