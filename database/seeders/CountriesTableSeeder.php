<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Country::truncate();
        $fp = fopen(storage_path('data/countries.csv'), 'r+');
        $header = null;
        $countriesChunk = [];
        $counter = 0;

        while (($data = fgetcsv($fp, null, ',')) !== false) {
            if (! $header) {
                $header = $data;

                continue;
            }

            $countriesChunk[] = array_combine($header, $data);
            $counter++;

            if ($counter < 250) {
                continue;
            }
            Country::insert($countriesChunk);
            $counter = 0;
            $countriesChunk = [];
        }

        fclose($fp);
        $this->command->info('Countries Seeded');
    }
}
