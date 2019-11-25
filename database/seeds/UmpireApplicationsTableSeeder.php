<?php

use Illuminate\Database\Seeder;

class UmpireApplicationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('umpire_applications')->insert([
            [
                'umpire_id' => 1,
                'tournament_id' => 3,
                'processed' => true,
                'approved' => false
            ],
            [
                'umpire_id' => 1,
                'tournament_id' => 2,
                'processed' => false,
                'approved' => false
            ],
            [
                'umpire_id' => 2,
                'tournament_id' => 3,
                'processed' => true,
                'approved' => true
            ]
        ]);
    }
}
