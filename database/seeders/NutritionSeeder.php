<?php

namespace Database\Seeders;

use App\Models\Admin\Nutrition;
use Illuminate\Database\Seeder;

class NutritionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Nutrition::truncate();
        Nutrition::insert([
            [
                'id' => 1,
                'name' => 'Sodium',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Fat',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'Sugar',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
