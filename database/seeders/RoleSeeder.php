<?php

namespace Database\Seeders;

use App\Models\Master\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'admin'
            ],
            [
                'name' => 'user'
            ],
            [
                'name' => 'kum'
            ],
            [
                'name' => 'kab'
            ],
            [
                'name' => 'msu'
            ],
            [
                'name' => 'pinca'
            ],
            [
                'name' => 'sdm'
            ]
        ];

        DB::unprepared('SET IDENTITY_INSERT roles ON');
        foreach ($roles as $key => $role) {
            Role::updateOrCreate([
                'id' => $key + 1
            ], [
                'name' => $role['name']
            ]);
        }
        DB::unprepared('SET IDENTITY_INSERT roles OFF');
    }
}
