<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        

        DB::table('users')->insert([
            'first_name' => 'Luke',
            'last_name' => 'Doucet',
            'email' => 'luke.doucet@icloud.com',
            'password' => bcrypt('123456'),
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString(),
        ]);

        // Create 10 random users.
        for ($i = 0; $i < 10; $i++) {
            DB::table('users')->insert([
                'first_name' => str_random(10),
                'last_name' => str_random(10),
                'email' => str_random(10) . '@gmail.com',
                'password' => bcrypt('123456'),
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);
        }

        
    }

}
