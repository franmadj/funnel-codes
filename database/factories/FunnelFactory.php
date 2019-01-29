<?php

use Faker\Generator as Faker;
use App\User;
use App\Tag;
use App\Funnel;
use Carbon\Carbon;

$factory->define(App\Funnel::class, function (Faker $faker) {
    $users = User::find([1]);
    
    $date = Carbon::create(2018, 1, 28, 0, 0, 0);
    
    
    return [
        'name' => $faker->word,
        'description' => $faker->paragraphs(2, true),
        'user_id' => function () use ($users) {
            if ($users->count()) {
                
                return $users->random()->id;
            }
            return 1;
        },
        'starts_at'=>$date->format('Y-m-d H:i:s'),
        'ends_at'=>$date->addWeeks(rand(1, 52))->format('Y-m-d H:i:s')
        
    ];
});
