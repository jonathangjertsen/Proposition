<?php

require __DIR__.'/../src/Proposition.php';

use Proposition\Proposition;

$proposition = new Proposition(30);
$proposition
    ->given(Proposition::arrays(Proposition::integers(), 10))
    ->call(function($arr) {
        echo ("Int array: [" . implode(",", $arr) . "]\n");
    });

$proposition = new Proposition(30);
$proposition
    ->given(Proposition::arrays(Proposition::letterStrings(5), 5))
    ->call(function($arr) {
        echo ("String array: [" . implode(",", $arr) . "]\n");
    });
