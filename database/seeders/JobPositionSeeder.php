<?php

namespace Database\Seeders;

use App\Models\Master\JobPosition;
use Illuminate\Contracts\Queue\Job;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $job_positions = [
            'AO Unit A',
            'AO Unit B',
            'SAO Unit B, Area B, Regional B',
            'SAO Unit C, Area C, Regional C',
        ];

        DB::unprepared('SET IDENTITY_INSERT job_positions ON');
        foreach ($job_positions as $key => $job_position) {
            JobPosition::updateOrCreate([
                'id' => $key + 1,
            ],[
                'name'       => $job_position,
                'created_by' => 1,
            ]);
        }
        DB::unprepared('SET IDENTITY_INSERT job_positions OFF');
    }
}
