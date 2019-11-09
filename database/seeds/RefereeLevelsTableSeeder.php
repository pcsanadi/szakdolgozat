<?php

use Illuminate\Database\Seeder;

class RefereeLevelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('referee_levels')->insert([
            [ 'level' => 'nincs' ],
            [ 'level' => 'országos' ],
            [ 'level' => 'BE accredited' ],
            [ 'level' => 'BE certificated' ],
            [ 'level' => 'BWF accredited' ],
            [ 'level' => 'BWF certificated' ]
        ]);
    }
}
