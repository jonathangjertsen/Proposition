<?php
require_once __DIR__.'/../vendor/autoload.php';

use Proposition\Proposition;

$input = [1,2,3,4,5,6,7,8,9];

echo ("\nInput array: [" . implode(", ", $input) . "]\n\n");

$proposition = new Proposition(15);
$proposition
    ->given(Proposition::arrayPermutations($input))
    ->call(function($arr) {
        echo("[" . implode(",", $arr) . "]\n");
    });
