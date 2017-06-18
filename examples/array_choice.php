<?php
require_once __DIR__.'/../vendor/autoload.php';

use Proposition\Proposition;

$input = [1, 2, 4, 8, 16];

echo ("\nNote: cycleThrough is guaranteed to cover all elements in the array,\nbut the order is not preserved.\n");
echo ("\nInput array: [" . implode(", ", $input) . "]\n\n");

$proposition = new Proposition(25);
$proposition
    ->given(Proposition::chooseFrom($input), Proposition::cycleThrough($input))
    ->call(function($elem1, $elem2) {
        echo ("chooseFrom: {$elem1}\tcycleThrough: {$elem2}\n");
    });
