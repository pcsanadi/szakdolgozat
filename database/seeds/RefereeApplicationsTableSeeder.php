<?php

use Illuminate\Database\Seeder;

class RefereeApplicationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('referee_applications')->insert([
            [
                'referee_id' => 3,
                'tournament_id' => 3,
                'processed' => false,
                'approved' => false
            ],
            [
                'referee_id' => 3,
                'tournament_id' => 2,
                'processed' => false,
                'approved' => false
            ]
        ]);
    }
}
