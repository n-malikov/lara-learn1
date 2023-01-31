<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserPhoneAuth extends Migration
{
    // php artisan make:migration add_user_phone_auth --table=users

    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('phone_auth')->default(false)->after('phone');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('phone_auth');
        });
    }
}
