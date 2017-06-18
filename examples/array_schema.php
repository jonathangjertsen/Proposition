<?php
require_once __DIR__.'/../vendor/autoload.php';

use Proposition\Proposition;

echo ("-------------------------------------
User schema: [
    'user_id' => int,
    'shopping_cart' => [
        0 => [
            'product_id' => int,
            'product_name' => string
        ],

        ...

        N => [
            'product_id' => int,
            'product_name' => string
        ]
    ]
-------------------------------------\n");

$proposition = new Proposition(3);
$proposition
    ->given(Proposition::arraySchema([
            'user_id' => Proposition::integerRange(0, 10000),
            'shopping_cart' => Proposition::arrays(Proposition::arraySchema([
                'product_id' => Proposition::integerRange(0, 100000000),
                'product_name' => Proposition::letterStrings(12)
            ]), 3)
    ]))
    ->call(function($arr) {
        var_export($arr);
        echo ("\n\n");
    });
