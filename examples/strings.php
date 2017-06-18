<?php

require_once __DIR__.'/../vendor/autoload.php';

use \Proposition\Proposition;

$MAX_STRLEN = 16;

$proposition = new Proposition(5);
$proposition
    ->given(Proposition::upperStrings($MAX_STRLEN))
    ->call(function($str) {
        echo ("Upper string: {$str}\n");
    })
    ->given(Proposition::lowerStrings($MAX_STRLEN))
    ->call(function($str) {
        echo ("Lower string: {$str}\n");
    })
    ->given(Proposition::letterStrings($MAX_STRLEN))
    ->call(function($str) {
        echo ("Letter string: {$str}\n");
    })
    ->given(Proposition::asciiStrings($MAX_STRLEN, false))
    ->call(function($str) {
        echo ("Ascii string: {$str}\n");
    })
    ->given(Proposition::asciiStrings($MAX_STRLEN, true))
    ->call(function($str) {
        echo ("Ascii string (extended): {$str}\n");
    })
    ->given(Proposition::base64Strings($MAX_STRLEN, false))
    ->call(function($str) {
        echo ("base64 string (default): {$str}\n");
    })
    ->given(Proposition::base64Strings($MAX_STRLEN, true))
    ->call(function($str) {
        echo ("base64 string (url): {$str}\n");
    })
    ->given(Proposition::hexStrings($MAX_STRLEN, false))
    ->call(function($str) {
        echo ("Hex string lower: {$str}\n");
    })
    ->given(Proposition::hexStrings($MAX_STRLEN, true))
    ->call(function($str) {
        echo ("Hex string upper: {$str}\n");
    });
