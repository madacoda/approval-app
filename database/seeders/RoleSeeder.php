<?php

namespace Database\Seeders;

use App\Models\Master\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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

        foreach ($roles as $key => $role) {
            Role::updateOrCreate([
                'id'   => $key + 1,
                'name' => $role['name']
            ]);
        }
    }
}
