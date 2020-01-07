<?php

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' =>null,
            'user_type' => 'super_admin',
            'password' =>'$2y$10$tHupsz0dXTrudk26oo5AgOifiDpluFASkRjSWmvleGo75xmGY4AP2',
            'remember_token'=>'ZMA3eSQ2pvvbfk7j2794TgjRCgAQzGlSCknM0MwsTglqbXLf9EgsoSwLBZ6Y', 
            'created_at' =>  '2019-12-31 11:49:29', 
            'updated_at' =>  '2020-01-02 10:37:36'
        ]); 

        DB::table('users')->insert([
            'name' => 'TEst',
            'email' => 'test@gmail.com',
            'email_verified_at' => null,
            'user_type' => 'Admin',
            'password' =>'$2y$10$1Qn/7HWL1Zce0duQUFQHK.3ZixC57tX3V11SSzDP5YTFZocLh1EBG', 
            'remember_token' =>null, 
            'created_at' => '2020-01-02 10:50:01', 
            'updated_at' => '2020-01-02 10:50:01'
        ]); 

        DB::table('statuses')->insert([
            'status' => 'Active',            
        ]); 
        DB::table('statuses')->insert([
            'status' => 'Disable',            
        ]); 
        DB::table('statuses')->insert([
            'status' => 'Pending',            
        ]); 
        DB::table('statuses')->insert([
            'status' => 'Success',            
        ]); 
        DB::table('statuses')->insert([
            'status' => 'Fail',            
        ]); 
        DB::table('statuses')->insert([
            'status' => 'Done',            
        ]); 
        DB::table('statuses')->insert([
            'status' => 'Finish',            
        ]); 

    }
}
