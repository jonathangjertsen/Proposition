<?php

require __DIR__.'/../src/Proposition.php';

use Proposition\Proposition;

$proposition = new Proposition(15);
$proposition
    ->given(Proposition::bools())
    ->call(function($bool) {
        $printable_bool = $bool ? "true" : "false";
        echo ("This bool is {$printable_bool}\n");
    });

