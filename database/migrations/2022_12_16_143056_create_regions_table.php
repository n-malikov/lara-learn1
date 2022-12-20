<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegionsTable extends Migration
{
    // php artisan make:migration create_regions_table

    /**
     * @return void
     */
    public function up()
    {
        Schema::create('regions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->index();
            $table->string('slug');
            $table->integer('parent_id')->nullable()->references('id')->on('regions')->onDelete('CASCADE');
            /*
             * laralearn
             * nullable - поле может быть пустым
             * если в onDelete указать RESTRICT, то БД не даст удалить строку, у которой есть дочерние элементы (те что на него ссылаются)
             * если SET NULL, то выставятся пустые значения у дочерних
             * если CASCADE, то удалятся все дочерние, при удалении родителя
             */
            $table->timestamps();
            $table->unique(['parent_id', 'slug']);
            $table->unique(['parent_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('regions');
    }
}
