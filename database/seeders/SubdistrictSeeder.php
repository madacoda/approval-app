<?php

namespace Database\Seeders;

use App\Models\Master\Subdistrict;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubdistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fileCsv = fopen(base_path('database/seeders/imports/subdistricts.csv'), 'r');

        $header = fgetcsv($fileCsv);
        $datas  = [];
        while (($row = fgetcsv($fileCsv)) !== false) {
            $datas[] = $row;
        }
        fclose($fileCsv);

        foreach($datas as $data) {
            $input['id'] = $data[0];
            $input['state'] = $data[1];
            $input['city'] = $data[2];
            $input['subdistrict'] = $data[3];

            Subdistrict::updateOrCreate($input);
        }
    }
}
