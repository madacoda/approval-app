<?php

namespace Database\Seeders;

use App\Models\Master\ApprovalConfig;
use App\Models\Master\ApprovalConfigDetail;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApprovalConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();
        
        DB::unprepared('SET IDENTITY_INSERT approval_configs ON');
        ApprovalConfig::updateOrCreate([
            'id' => 1
        ], [
            'name'        => 'Approval',
            'description' => 'Approval config for module approval',
            'module'      => 'approval',
            'is_active'   => 1,
        ]);
        DB::unprepared('SET IDENTITY_INSERT approval_configs OFF');

        $kab   = User::where('email', 'kab@madacoda.dev')->first();
        $msu   = User::where('email', 'msu@madacoda.dev')->first();
        $pinca = User::where('email', 'pinca@madacoda.dev')->first();
        $sdm   = User::where('email', 'sdm@madacoda.dev')->first();

        DB::unprepared('SET IDENTITY_INSERT approval_config_details ON');
        ApprovalConfigDetail::updateOrCreate([
            'id' => 1
        ], [
            'approval_config_id' => 1,
            'sequence_number'    => 2,
            'module'             => 'user',
            'module_id'          => $msu->id,
        ]);

        ApprovalConfigDetail::updateOrCreate([
            'id' => 2
        ], [
            'approval_config_id' => 1,
            'sequence_number'    => 3,
            'module'             => 'user',
            'module_id'          => $pinca->id,
        ]);

        ApprovalConfigDetail::updateOrCreate([
            'id' => 3
        ], [
            'approval_config_id' => 1,
            'sequence_number'    => 4,
            'module'             => 'user',
            'module_id'          => $sdm->id,
        ]);
        DB::unprepared('SET IDENTITY_INSERT approval_config_details OFF');

        DB::commit();
    }
}
