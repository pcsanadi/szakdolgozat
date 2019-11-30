<?php

/*
|--------------------------------------------------------------------------
| Custom Validation Language Lines
|--------------------------------------------------------------------------
|
| Here you may specify custom validation messages for attributes using the
| convention "attribute.rule" to name the lines. This makes it quick to
| specify a specific custom language line for a given attribute rule.
|
*/

return [
    'date' => 'Ebbe a mezőbe dátumot írj',
    'numeric' => 'Ebbe a mezőbe csak számot írj',

    'custom' => [
        'address' => [
            'required' => 'Adj meg címet',
            'unique' => 'Ez a cím már szerepel az adatbázisban',
        ],
        'datefrom' => [
            'required' => 'Kezdődátum megadása kötelező',
            'before_or_equal' => 'Ez a dátum nem lehet későbbi, mint a végdátum',
        ],
        'dateto' => [
            'required' => 'Végdátum megadása kötelező',
            'after_or_equal' => 'Ez a dátum nem lehet korábbi, mint a kezdődátum',
        ],
        'email' => [
            'required' => 'Adj meg egy email címet',
            'unique' => 'Ez az email cím már szerepel az adatbázisban',
        ],
        'name' => [
            'required' => 'Adj meg egy nevet',
            'unique' => 'Ez a név már szerepel az adatbázisban',
        ],
        'rlevel' => [
            'required' => 'Válassz egy döntnöki szintet',
        ],
        'short_name' => [
            'required' => 'Adj meg egy rövid nevet',
            'unique' => 'Ez a rövid név már szerepel az adatbázisban',
        ],
        'ulevel' => [
            'required' => 'Válassz egy játékvezetői szintet',
        ],
        'title' => [
            'required' => 'Add meg a megnevezést',
        ],
        'venue' => [
            'required' => 'Válassz egy csarnokot',
        ],
    ],
];