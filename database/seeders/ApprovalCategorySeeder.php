<?php

namespace Database\Seeders;

use App\Models\Master\ApprovalCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApprovalCategorySeeder extends Seeder
{
      /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $approval_categories = [
            [
                'name'       => 'MMI - Mekaar - Promosi',
                'created_by' => 1,
            ],
            [
                'name'       => 'MMI - Mekaar - Mutasi',
                'created_by' => 1,
            ],
            [
                'name'       => 'MMI - Mekaar - Mutasi Penyesuaian Gaji',
                'created_by' => 1,
            ],
            [
                'name'       => 'MMI - Mekaar - Rotasi',
                'created_by' => 1,
            ]
        ];

        DB::unprepared('SET IDENTITY_INSERT approval_categories ON');
        foreach ($approval_categories as $key => $approval_category) {
            ApprovalCategory::updateOrCreate([
                'id' => $key + 1,
            ], $approval_category);
        }
        DB::unprepared('SET IDENTITY_INSERT approval_categories OFF');
    }
}
