<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            //GroupsTableSeeder::class,
            //GroupLocationsSeeder::class,
            //ContactsTableSeeder::class,
            CompaniesTableSeeder::class,
            //AffiliatesTableSeeder::class,
            TasksTableSeeder::class,
            // ProspectsTableSeeder::class,
            DocumentsTableSeeder::class,
            // ChatsTableSeeder::class,
            // ChatConversationsTableSeeder::class
        ]);
    }
}
