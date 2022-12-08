<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserRole extends Migration
{
    // php artisan make:migration add_user_role --table=users

    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role', 16);
        });

        DB::table('users')->update([ // laralearn всем уже существующим заполнить поле значением user
            'role' => 'user',
        ]);
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
}
