<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            ApprovalCategorySeeder::class,
            JobPositionSeeder::class,
            SubdistrictSeeder::class,
            SubdistrictPostcodeSeeder::class,
            ApprovalConfigSeeder::class,
        ]);
        // \App\Models\User::factory(10)->create();
    }
}
