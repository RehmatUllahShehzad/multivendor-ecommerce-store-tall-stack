<?php

namespace Database\Seeders;

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
        $this->call(DefaultAdminSeeder::class);
        $this->call(StatesTableSeeder::class);
        $this->call(CountriesTableSeeder::class);
        $this->call(NutritionSeeder::class);
        $this->call(UnitSeeder::class);
        $this->call(PageSeeder::class);
        $this->call(MenuSeeder::class);
        $this->call(CategorySeeder::class);
    }
}
