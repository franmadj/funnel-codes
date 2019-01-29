<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Funnel;
use App\Tag;
use Carbon\Carbon;

class FunnelsTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $tags = Tag::find([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);


        factory(Funnel::class, 10)->create()->each(function($funnel) use ($tags) {


            if ($tags->count()) {
                $funnel->tags()->attach($tags->random(rand(1, $tags->count()))->pluck('id')->toArray());
            }

            
        });







        /*
          DB::table('funnels')->insert([
          'user_id' => 11,
          'name' => 'Silky Lotion',
          'description' => 'A new product we are trying to push.',
          'starts_at' => Carbon::now()->toDateTimeString(),
          'ends_at' => Carbon::now()->toDateTimeString(),
          'status' => 1,
          'created_at' => Carbon::now()->toDateTimeString(),
          'updated_at' => Carbon::now()->toDateTimeString(),
          ]);

          DB::table('funnels')->insert([
          'user_id' => 11,
          'name' => 'Shoes',
          'description' => 'Trying to beat competitors.',
          'starts_at' => Carbon::now()->toDateTimeString(),
          'ends_at' => Carbon::now()->toDateTimeString(),
          'status' => 1,
          'created_at' => Carbon::now()->toDateTimeString(),
          'updated_at' => Carbon::now()->toDateTimeString(),
          ]);

          DB::table('funnels')->insert([
          'user_id' => 11,
          'name' => str_random(10),
          'description' => str_random(10),
          'starts_at' => Carbon::now()->toDateTimeString(),
          'ends_at' => Carbon::now()->toDateTimeString(),
          'status' => 1,
          'created_at' => Carbon::now()->toDateTimeString(),
          'updated_at' => Carbon::now()->toDateTimeString(),
          ]);

          DB::table('funnels')->insert([
          'user_id' => 11,
          'name' => str_random(10),
          'description' => str_random(10),
          'starts_at' => Carbon::now()->toDateTimeString(),
          'ends_at' => Carbon::now()->toDateTimeString(),
          'status' => 1,
          'created_at' => Carbon::now()->toDateTimeString(),
          'updated_at' => Carbon::now()->toDateTimeString(),
          ]);

          DB::table('funnels')->insert([
          'user_id' => 11,
          'name' => str_random(10),
          'description' => str_random(10),
          'starts_at' => Carbon::now()->toDateTimeString(),
          'ends_at' => Carbon::now()->toDateTimeString(),
          'status' => 1,
          'created_at' => Carbon::now()->toDateTimeString(),
          'updated_at' => Carbon::now()->toDateTimeString(),
          ]);

          DB::table('funnels')->insert([
          'user_id' => 11,
          'name' => str_random(10),
          'description' => str_random(10),
          'starts_at' => Carbon::now()->toDateTimeString(),
          'ends_at' => Carbon::now()->toDateTimeString(),
          'status' => 1,
          'created_at' => Carbon::now()->toDateTimeString(),
          'updated_at' => Carbon::now()->toDateTimeString(),
          ]);

          DB::table('funnels')->insert([
          'user_id' => 11,
          'name' => str_random(10),
          'description' => str_random(10),
          'starts_at' => Carbon::now()->toDateTimeString(),
          'ends_at' => Carbon::now()->toDateTimeString(),
          'status' => 1,
          'created_at' => Carbon::now()->toDateTimeString(),
          'updated_at' => Carbon::now()->toDateTimeString(),
          ]);

          DB::table('funnels')->insert([
          'user_id' => 11,
          'name' => str_random(10),
          'description' => str_random(10),
          'starts_at' => Carbon::now()->toDateTimeString(),
          'ends_at' => Carbon::now()->toDateTimeString(),
          'status' => 1,
          'created_at' => Carbon::now()->toDateTimeString(),
          'updated_at' => Carbon::now()->toDateTimeString(),
          ]);

          DB::table('funnels')->insert([
          'user_id' => 11,
          'name' => str_random(10),
          'description' => str_random(10),
          'starts_at' => Carbon::now()->toDateTimeString(),
          'ends_at' => Carbon::now()->toDateTimeString(),
          'status' => 1,
          'created_at' => Carbon::now()->toDateTimeString(),
          'updated_at' => Carbon::now()->toDateTimeString(),
          ]);

          DB::table('funnels')->insert([
          'user_id' => 11,
          'name' => str_random(10),
          'description' => str_random(10),
          'starts_at' => Carbon::now()->toDateTimeString(),
          'ends_at' => Carbon::now()->toDateTimeString(),
          'status' => 1,
          'created_at' => Carbon::now()->toDateTimeString(),
          'updated_at' => Carbon::now()->toDateTimeString(),
          ]);

          DB::table('funnels')->insert([
          'user_id' => 11,
          'name' => str_random(10),
          'description' => str_random(10),
          'starts_at' => Carbon::now()->toDateTimeString(),
          'ends_at' => Carbon::now()->toDateTimeString(),
          'status' => 1,
          'created_at' => Carbon::now()->toDateTimeString(),
          'updated_at' => Carbon::now()->toDateTimeString(),
          ]);

          DB::table('funnels')->insert([
          'user_id' => 11,
          'name' => str_random(10),
          'description' => str_random(10),
          'starts_at' => Carbon::now()->toDateTimeString(),
          'ends_at' => Carbon::now()->toDateTimeString(),
          'status' => 1,
          'created_at' => Carbon::now()->toDateTimeString(),
          'updated_at' => Carbon::now()->toDateTimeString(),
          ]); */
    }

}
