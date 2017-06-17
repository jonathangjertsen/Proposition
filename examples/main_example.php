<?php

require __DIR__.'/../src/Proposition.php';

use Proposition\Proposition;

// Test whether our assumption, that $a is always bigger than $b, holds for all integers passed into it.

$proposition = new Proposition();

$proposition
    // First, we define the values to pass in with given()...
    ->given(
        Proposition::integerRange(5, 20),  // Values from here will be passed as $a
        Proposition::integerRange(-10, 10) // Values from here will be passed as $b
    )
    // ...then we define the function to run with check().
    ->check(function($a, $b) {
        // Typically you would use an asser in here, not an if.

        if ($a > $b) {
            // It was correct: indicate success!
            echo ("Yup, $a is bigger than $b\n");
        } else {
            // It was not correct, indicate error!
            echo ("NO! $a is NOT bigger than $b!!\n");
        }

    });
