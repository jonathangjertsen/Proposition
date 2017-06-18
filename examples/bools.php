<?php

require __DIR__.'/../src/Proposition.php';

use Proposition\Proposition;

$proposition = new Proposition(5);
$proposition
    ->given(Proposition::bools())
    ->call(function($bool) {
        $printable_bool = $bool ? "true" : "false";
        echo ("That's {$printable_bool}\n");
    });

