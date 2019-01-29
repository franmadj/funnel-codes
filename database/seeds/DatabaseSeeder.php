<?php

use Illuminate\Database\Seeder;
use App\Tag;

class DatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        
       
        $this->truncateTables();
        $this->call([
            UsersTableSeeder::class,
            TagsTableSeeder::class,
            FunnelsTableSeeder::class,

        ]);
    }

    private function truncateTables() {
        $skip = [
            'migrations',
            'oauth_access_tokens',
            'oauth_auth_codes',
            'oauth_clients',
            'oauth_personal_access_clients',
            'oauth_refresh_tokens',
            'api_tokens',
            'password_resets',
            'notifications',
            'invitations',
            'announcements',
            'team_users'
        ];
        
        //specific for postgreSQL
        
       

        $tableNames = DB::select("SELECT table_name FROM information_schema.tables WHERE table_schema = 'public'");
        
        foreach ($tableNames as $name) {
            
            $name = array_values((array) $name)[0];
            //if you don't want to truncate migrations
            if (in_array($name, $skip)) {
                continue;
            }
            
            DB::statement('TRUNCATE TABLE ' . $name . ' CASCADE;');
            DB::statement('alter sequence ' . $name . '_id_seq RESTART WITH 1;');
            
            
        }
        
        
       

        
    }

}
