<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Csanádi Péter',
                'email' => 'peter.csanadi.840128@gmail.com',
                'password' => Hash::make('1111'),
                'umpire_level' => 'BE accredited',
                'referee_level' => 1,
                'admin' => true,
                'deleted' => false
            ],
            [
                'name' => 'Kapitány Péter',
                'email' => 'peter.kapitany@gmail.com',
                'password' => Hash::make('2222'),
                'umpire_level' => 'none',
                'referee_level' => 0,
                'admin' => false,
                'deleted' => false
            ]
        ]);
    }
}
