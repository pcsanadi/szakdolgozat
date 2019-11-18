<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VenuesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('venues')->insert([
            [
                'name' => 'Multi Alarm SE Tollaslabda Csarnok',
                'short_name' => 'Multi',
                'address' => '7630 Pécs, Basamalom út 33.',
                'courts' => 9
            ],
            [
                'name' => 'Hodos Tamás Tollaslabda Csarnok',
                'short_name' => 'Hodos',
                'address' => '1044 Budapest, Váci út 102.',
                'courts' => 10
            ],
            [
                'name' => 'Living Sport Tollaslabda Csarnok',
                'short_name' => 'Cegléd',
                'address' => '2700 Cegléd, Mizsei út',
                'courts' => 9
            ]
        ]);
    }
}
