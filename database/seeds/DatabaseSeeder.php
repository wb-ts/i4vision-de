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
        // $this->call(UserSeeder::class);
        DB::table('users')->insert([
            "email" => "super_admin@gmail.com",
            "first_name" => "super",
            "last_name" => "admin",
            "username" => "super_admin",
            "phone" => "11111111111",
            "type" => "super_admin",
            "password" => bcrypt('admin123')
        ]);
    }
}
