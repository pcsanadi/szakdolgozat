<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UmpireLevelsTableSeeder::class);
        $this->call(RefereeLevelsTableSeeder::class);
        $this->call(VenuesTableSeeder::class);
        $this->call(TournamentsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
