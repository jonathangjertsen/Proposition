<?php

require __DIR__.'/../src/Proposition.php';

use Proposition\Proposition;

$proposition = new Proposition(30, 30);
$proposition
    ->given(
        [
            Proposition::integerRange(0, 100),
            Proposition::letterStrings(4),
            Proposition::bools()
        ]
    )
    ->call(function($something) {
        $type = gettype($something);
        if ($type == "boolean") {
            $something = $something ? "true" : "false";
        }
        echo ("Got a $something, a $type!\n");
    });
