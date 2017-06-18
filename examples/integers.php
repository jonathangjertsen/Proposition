<?php

require __DIR__.'/../src/Proposition.php';

use Proposition\Proposition;

$proposition = new Proposition();

$proposition
    ->given(Proposition::integerRange(0, 50), Proposition::everyInteger(0, 50, 2), Proposition::integers())
    ->call(function($a, $b, $c) {
        echo ("In range: $a, All in range: $b, Any: $c\n");
    });