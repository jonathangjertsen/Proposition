<?php

require __DIR__.'/../src/Proposition.php';

use Proposition\Proposition;

$proposition = new Proposition(30);
$proposition
    ->given(Proposition::floats(), Proposition::floatRange(-5, 5))
    ->call(function($unlimited_float, $limited_float) {
        echo ("Unlimited float: $unlimited_float, Limited float: $limited_float\n");
    });
