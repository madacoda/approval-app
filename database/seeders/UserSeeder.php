<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name'            => 'Admin Approval App',
                'email'           => 'admin@madacoda.dev',
                'password'        => bcrypt('admin'),
                'role_id'         => 1,
                'identity_number' => '1234567890',
                'employee_number' => '0001',
                'hb_distance'     => '18KM',
                'unit'            => 'Batuputih',
                'area'            => 'Area Batuputih Laok 1'
            ], [
                'name'            => 'Sauki KUM',
                'email'           => 'kum@madacoda.dev',
                'password'        => bcrypt('admin'),
                'role_id'         => 3,
                'identity_number' => '1234567891',
                'employee_number' => '0002',
                'hb_distance'     => '28KM',
                'unit'            => 'Batuputih',
                'area'            => 'Area Batuputih Laok 1'
            ],
            [
                'name'            => 'Sauki Abdillah',
                'email'           => 'kab@madacoda.dev',
                'password'        => bcrypt('admin'),
                'role_id'         => 4,
                'identity_number' => '1234567892',
                'employee_number' => '0003',
                'hb_distance'     => '7KM',
                'unit'            => 'Bluto',
                'area'            => 'Area Bluto 1',
                'branch'          => 'Cabang Sumenep',
                'regional'        => 'Regional Madura'
            ],
            [
                'name'            => 'Abdul Kadir',
                'email'           => 'msu@madacoda.dev',
                'password'        => bcrypt('admin'),
                'role_id'         => 5,
                'identity_number' => '1234567893',
                'employee_number' => '0004',
                'hb_distance'     => '4KM',
                'unit'            => 'Bluto',
                'area'            => 'Area Bluto 1',
                'branch'          => 'Cabang Sumenep',
                'regional'        => 'Regional Madura'
            ],
            [
                'name'            => 'Taufik Arifin',
                'email'           => 'pinca@madacoda.dev',
                'password'        => bcrypt('admin'),
                'role_id'         => 6,
                'identity_number' => '1234567894',
                'employee_number' => '0005',
                'hb_distance'     => '16KM',
                'unit'            => 'Bluto',
                'area'            => 'Area Bluto 1',
                'branch'          => 'Cabang Sumenep',
                'regional'        => 'Regional Madura'
            ],
            [
                'name'            => 'Yusuf Ismail',
                'email'           => 'sdm@madacoda.dev',
                'password'        => bcrypt('admin'),
                'role_id'         => 7,
                'identity_number' => '1234567895',
                'employee_number' => '0006',
                'hb_distance'     => '12KM',
                'unit'            => 'Bluto',
                'area'            => 'Area Bluto 1',
                'branch'          => 'Cabang Sumenep',
                'regional'        => 'Regional Madura'
            ],
            [
                'name'            => 'Hamada',
                'email'           => 'hamada@madacoda.dev',
                'password'        => bcrypt('user'),
                'role_id'         => 2,
                'identity_number' => '1234567896',
                'employee_number' => '0007',
                'hb_distance'     => '12KM',
                'unit'            => 'Batang Batang',
                'area'            => 'Area Batang Batang 1',
                'job_position_id' => 1,
            ],
            [
                'name'            => 'Ananta',
                'email'           => 'ananta@madacoda.dev',
                'password'        => bcrypt('user'),
                'role_id'         => 2,
                'identity_number' => '1234567897',
                'employee_number' => '0008',
                'hb_distance'     => '13KM',
                'unit'            => 'Batang Batang',
                'area'            => 'Area Batang Batang 2',
                'job_position_id' => 1,
            ],
            [
                'name'            => 'Burhanuddin',
                'email'           => 'burhanuddin@madacoda.dev',
                'password'        => bcrypt('user'),
                'role_id'         => 2,
                'identity_number' => '1234567898',
                'employee_number' => '0009',
                'hb_distance'     => '14KM',
                'unit'            => 'Batang Batang',
                'area'            => 'Area Batang Batang 3',
                'job_position_id' => 1,
            ]
        ];

        DB::beginTransaction();
        foreach ($users as $key => $user) {
            $userDB = User::updateOrCreate([
                'email' => $user['email']
            ], [
                'name'     => $user['name'],
                'email'    => $user['email'],
                'password' => $user['password'],
                'role_id'  => $user['role_id'],
            ]);
            
            Employee::updateOrCreate([
                'user_id' => $userDB->id,
            ],[
                'employee_number' => $user['employee_number'],
                'identity_number' => $user['identity_number'],
                'unit'            => $user['unit'],
                'area'            => $user['area'],
                'hb_distance'     => $user['hb_distance'],
                'job_position_id' => $user['job_position_id'] ?? null,
                'branch'          => $user['branch'] ?? null,
                'regional'        => $user['regional'] ?? null
            ]);
        }
        DB::commit();
    }
}
