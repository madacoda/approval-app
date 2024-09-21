<?php

namespace Database\Seeders;

use App\Models\Master\Subdistrict;
use App\Models\Master\SubdistrictPostcode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubdistrictPostcodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fileCsv = fopen(base_path('database/seeders/imports/subdistrict_postcodes.csv'), 'r');

        $header = fgetcsv($fileCsv);
        $datas  = [];
        while (($row = fgetcsv($fileCsv)) !== false) {
            $datas[] = $row;
        }
        fclose($fileCsv);

        foreach($datas as $data) {
            $input['id']             = $data[0];
            $input['subdistrict_id'] = $data[1];
            $input['postcode']       = $data[2];
            $subdistrict             = Subdistrict::find($input['subdistrict_id']);
            if(!$subdistrict) {
                continue;
            }
            SubdistrictPostcode::updateOrCreate($input);
        }
    }
}
