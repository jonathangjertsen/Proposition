<?php

require_once __DIR__.'/../vendor/autoload.php';

use Proposition\Proposition;

$proposition = new Proposition();

echo ("\nRange goes from 0 to 50.\n\n");

$proposition
    ->given(Proposition::integerRange(0, 50), Proposition::everyInteger(0, 50, 2), Proposition::integers())
    ->call(function($a, $b, $c) {
        echo ("In range: $a\tAll in range: $b \tAny: $c\n");
    });
