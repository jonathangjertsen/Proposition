<?php
require __DIR__.'/../src/Proposition.php';

use Proposition\Proposition;

$proposition = new Proposition(3);
$proposition
    ->given(Proposition::arrayPermutations([1,2,3,4,5,6,7,8,9]))
    ->call(function($arr) {
        echo("[" . implode(",", $arr) . "]\n");
    });
