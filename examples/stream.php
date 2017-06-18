<?php

require_once __DIR__.'/../vendor/autoload.php';

use Proposition\Proposition;

$proposition = new Proposition(15);
$proposition
    ->given(Proposition::stream(function() {
        return mt_rand(-9, 9) % 3;
    }))
    ->call(function($int) {
        echo("$int\n");
    });
