<?php

use App\Entity\Region;
use Illuminate\Database\Seeder;

class RegionsTableSeeder extends Seeder
{
    //php artisan make:seeder RegionsTableSeeder

    // запустить этот сидер:
    // php artisan db:seed --class=RegionsTableSeeder

    /**
     * @return void
     */
    public function run() : void
    {
        // laralearn сначала создаем 10 регионов, и с помощью each в каждом из них выполним еще эти функции:
        factory(Region::class, 10)->create()->each(function (Region $region) {
            $region->children()->saveMany(factory(Region::class, random_int(3, 10))->create()->each(function (Region $region) {
                $region->children()->saveMany(factory(Region::class, random_int(3, 10))->make());
            }));
        });
    }
}
