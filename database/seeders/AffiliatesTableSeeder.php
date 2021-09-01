<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AffiliatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Affiliate::factory()->count(50)->create();
    }
}
