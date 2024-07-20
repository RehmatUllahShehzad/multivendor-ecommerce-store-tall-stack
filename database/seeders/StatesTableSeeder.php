<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Seeder;

class StatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        State::truncate();
        $fp = fopen(storage_path('data/states.csv'), 'r+');

        $header = null;
        $statesChunk = [];
        $counter = 0;
        $dd = 0;

        while (($data = fgetcsv($fp, null, ',')) !== false) {
            if (! $header) {
                $header = $data;

                continue;
            }
            $statesChunk[] = array_combine($header, $data);
            $counter++;
            if ($counter < 500) {
                continue;
            }

            State::insert($statesChunk);
            $counter = 0;
            $statesChunk = [];
            $dd = 0;
        }

        fclose($fp);
        $this->command->info('States Seeded');
    }
}
