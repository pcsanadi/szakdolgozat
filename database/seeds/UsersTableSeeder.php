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
                'umpire_level' => 3,
                'referee_level' => 2,
                'admin' => true
            ],
            [
                'name' => 'Kapitány Péter',
                'email' => 'peter.kapitany@gmail.com',
                'password' => Hash::make('2222'),
                'umpire_level' => 1,
                'referee_level' => 2,
                'admin' => false
            ],
            [
                'name' => 'Balogh Richárd',
                'email' => 'rbalogh@gmail.com',
                'password' => Hash::make('3333'),
                'umpire_level' => 1,
                'referee_level' => 3,
                'admin' => false
            ],
            [
                'name' => 'Varga Miklós',
                'email' => 'varga.miklos@variovision.hu',
                'password' => Hash::make('4444'),
                'umpire_level' => 3,
                'referee_level' => 2,
                'admin' => false
            ]
        ]);
    }
}
