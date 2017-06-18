<?php

require __DIR__.'/../src/Proposition.php';

use Proposition\Proposition;

$proposition = new Proposition(3);
$proposition
    ->given(Proposition::stream(function() {
        return mt_rand(-9, 9) % 3;
    }))
    ->call(function($int) {
        echo("$int\n");
    });
