<?php
require __DIR__.'/../src/Proposition.php';

use Proposition\Proposition;

$proposition = new Proposition(3);
$proposition
    ->given(Proposition::arraySchema([
            'user_id' => Proposition::integerRange(0, 10000),
            'shopping_cart' => Proposition::arrays(Proposition::arraySchema([
                'product_id' => Proposition::integerRange(0, 100000000),
                'product_name' => Proposition::letterStrings(12)
            ]), 6)
    ]))
    ->call(function($arr) {
        var_dump($arr);
    });
