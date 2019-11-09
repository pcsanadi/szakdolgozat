<?php

use Illuminate\Database\Seeder;

class UmpireLevelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('umpire_levels')->insert([
            [ 'level' => 'nincs' ],
            [ 'level' => 'országos' ],
            [ 'level' => 'BE accredited' ],
            [ 'level' => 'BE certificated' ],
            [ 'level' => 'BWF accredited' ],
            [ 'level' => 'BWF certificated' ]
        ]);
    }
}
