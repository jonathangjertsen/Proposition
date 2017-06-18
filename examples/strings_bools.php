<?php

require __DIR__.'/../src/Proposition.php';

use Proposition\Proposition;

$proposition = new Proposition(5);
$proposition
    ->given(Proposition::letterStrings(10), Proposition::bools())
    ->call(function($str, $bool) {
        $printable_bool = $bool ? "true" : "false";
        echo ("Called with {$str} and {$printable_bool}\n");
    });

$proposition = new Proposition(5);
$proposition
    ->given(Proposition::upperLetterStrings(10))
    ->call(function($str) {
        echo ("Called with {$str}\n");
    });

$proposition = new Proposition(5);
$proposition
    ->given(Proposition::lowerLetterStrings(10))
    ->call(function($str) {
        echo ("Called with {$str}\n");
    });

$proposition = new Proposition(5);
$proposition
    ->given(Proposition::asciiStrings(10))
    ->call(function($str) {
        echo ("Called with {$str}\n");
    });

$proposition = new Proposition(5);
$proposition
    ->given(Proposition::asciiStrings(10, true))
    ->call(function($str) {
        echo ("Called with {$str}\n");
    });
