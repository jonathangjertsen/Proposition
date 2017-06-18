<?php

require_once __DIR__.'/../vendor/autoload.php';

use Proposition\Proposition;

$proposition = new Proposition(30, 30);
$proposition
    ->given(Proposition::arrays(Proposition::integers(), 10))
    ->call(function($arr) {
        echo ("Int array: [" . implode(",", $arr) . "]\n");
    });

$proposition = new Proposition(30, 30);
$proposition
    ->given(Proposition::arrays(Proposition::letterStrings(5), 5))
    ->call(function($arr) {
        echo ("String array: [" . implode(",", $arr) . "]\n");
    });

$proposition = new Proposition(30, 30);
$proposition
    ->given(Proposition::fixedLengthArrays(Proposition::arrays(Proposition::integers(), 3), 3))
    ->call(function($arr) {
        echo ("Array array with 3 elements: [" .
                implode(",", array_map( function($subarr) { return "[" . implode(",", $subarr) . "]"; }, $arr)) .
            "]\n");
    });
