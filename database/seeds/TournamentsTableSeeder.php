<?php

use Illuminate\Database\Seeder;

class TournamentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tournaments')->insert([
            [
                'title' => 'Felnőtt Országos Bajnokság',
                'datefrom' => '20200201',
                'dateto' => '20200202',
                'venue_id' => 1,
                'requested_umpires' => 13
            ],
            [
                'title' => 'Budapest Bajnokság',
                'datefrom' => '20200118',
                'dateto' => '20200118',
                'venue_id' => 2,
                'requested_umpires' => 15
            ],
            [
                'title' => '10th Multi Alarm Hungarian Junior Championships',
                'datefrom' => '20200206',
                'dateto' => '20200209',
                'venue_id' => 1,
                'requested_umpires' => 0
            ],
            [
                'title' => 'Vízmű Kupa U11 U15 U19',
                'datefrom' => '20190921',
                'dateto' => '20190921',
                'venue_id' => 1,
                'requested_umpires' => 15
            ],
            [
                'title' => 'Senior OB',
                'datefrom' => '20181124',
                'dateto' => '20181124',
                'venue_id' => 3,
                'requested_umpires' => 0
            ],
            [
                'title' => 'Csapatbajnokság I. 2. forduló',
                'datefrom' => '20190126',
                'dateto' => '20190127',
                'venue_id' => 1,
                'requested_umpires' => 6
            ]
        ]);
    }
}
