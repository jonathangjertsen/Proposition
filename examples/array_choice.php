<?php
require __DIR__.'/../src/Proposition.php';

use Proposition\Proposition;

$input = [10, 20, 30, 40, 50];

$proposition = new Proposition(25);
$proposition
    ->given(Proposition::chooseFrom($input), Proposition::cycleThrough($input))
    ->call(function($elem1, $elem2) {
        echo ("Random choice: {$elem1}, cycle: {$elem2}\n");
    });
