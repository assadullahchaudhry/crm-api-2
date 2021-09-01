<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProspectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Prospect::factory()->count(50)->create();
    }
}
