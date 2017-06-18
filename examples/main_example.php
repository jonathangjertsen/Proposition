<?php

require_once __DIR__.'/../vendor/autoload.php';

use Proposition\Proposition;

// Here's a toy example showing how you would use Proposition to check whether your awesome reimplementation of
// abs($a) == abs($b) actually works.

function equal_magnitude($a, $b)
{
    return ($a = $b) || ($a == -$b);
}

$proposition = new Proposition();

$proposition
    ->given(Proposition::integers(), Proposition::integers())
    ->call(function($a, $b) {
        if(equal_magnitude($a, $b) != (abs($a) == abs($b))) {
            echo "ERROR!! it is wrong when \$a is $a and \$b is $b!!\n";
        } else {
            echo "it seems to work when \$a is $a and \$b is $b.\n";
        }
    });

// Oops! We're getting a lot of error messages. We will quickly discover that we used = where we should have used == in
// our function.

// In practice, you will be using this to pass a huge, automatically generated range of values into your functions and
// check that some property always holds. You might for example want to check that the output of a function has a
// certain relationship to your input, that the function did or did not throw an exception, and so on.
