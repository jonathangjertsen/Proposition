<?php

require __DIR__.'/../src/Proposition.php';

use Proposition\Proposition;

$proposition = new Proposition(30, 30);
$proposition
    ->given(
        [Proposition::integerRange(0, 100), Proposition::letterStrings(4), Proposition::bools()],
        Proposition::integers()
    )
    ->call(function($something, $int) {
        $type = gettype($something);
        $inttype = gettype($int);
        echo ("It's $something, a $type! But $int is still an $inttype.\n");
    });
