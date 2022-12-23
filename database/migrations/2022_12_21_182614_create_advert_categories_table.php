<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Kalnoy\Nestedset\NestedSet;

class CreateAdvertCategoriesTable extends Migration
{
    // php artisan make:migration create_advert_categories_table

    /**
     * @return void
     */
    public function up()
    {
        Schema::create('advert_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->index();
            $table->string('slug');
            NestedSet::columns($table);
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('advert_categories');
    }
}
