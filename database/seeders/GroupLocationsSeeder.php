<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GroupLocationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\GroupLocation::factory()->count(50)->create();
    }
}
