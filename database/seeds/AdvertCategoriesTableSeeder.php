<?php

use App\Entity\Adverts\Category;
use Illuminate\Database\Seeder;

class AdvertCategoriesTableSeeder extends Seeder
{
    // php artisan make:seeder AdvertCategoriesTableSeeder

    // запустить этот сидер:
    // php artisan db:seed --class=AdvertCategoriesTableSeeder

    /**
     * @throws Exception
     * @return void
     */
    public function run()
    {
        factory(Category::class, 10)->create()->each(function (Category $category) {
            $counts = [0, random_int(3, 7)];
            $category->children()->saveMany(factory(Category::class, $counts[array_rand($counts)])->create()->each(function (Category $category) {
                $counts = [0, random_int(3, 7)];
                $category->children()->saveMany(factory(Category::class, $counts[array_rand($counts)])->create());
            }));
        });
    }
}
