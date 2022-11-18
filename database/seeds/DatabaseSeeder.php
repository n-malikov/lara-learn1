<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    // php artisan db:seed
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
    }
}
