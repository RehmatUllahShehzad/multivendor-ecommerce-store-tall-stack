<?php

namespace Database\Seeders;

use App\Models\Admin\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Unit::truncate();
        Unit::insert([
            [
                'id' => 1,
                'name' => 'Gram',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Kg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'Mg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
