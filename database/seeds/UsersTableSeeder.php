<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    // запустить этот сидер:
    // php artisan db:seed --class=UsersTableSeeder

    /**
     * @return void
     */
    public function run()
    {
        factory(User::class, 10)->create();
    }
}
