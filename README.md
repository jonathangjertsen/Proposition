# Proposition
Lightweight property-based testing library for PHP. Inspired by Python's Hypothesis library.

## Documentation

See the [Wiki](https://github.com/jonathangjertsen/Proposition/wiki)

## Example usage

Here's a toy example showing how you would use Proposition to check whether your awesome reimplementation of `abs($a) == abs($b)` actually works.

    function equal_magnitude($a, $b)
    {
        return ($a = $b) || ($a == -$b);
    }

    $proposition = new Proposition();

    $proposition
        ->given(Proposition::integers(), Proposition::integers())
        ->call(function($a, $b) {
            if(equal_magnitude($a, $b) != (abs($a) == abs($b))) {
                echo "ERROR!! equal_magnitude is wrong when \$a is $a and \$b is $b!\n"; 
            }
        });

Oops! We're getting a lot of error messages. We will quickly discover that we used a `=` where we should have used a `==` in our function.

In practice, you will be using this to pass a huge, automatically generated range of values into your functions and check that some property *always* holds. You might for example want to check that the output of a function has a certain relationship to your input, that the function did or did not throw an exception, and so on.

## Project goals

* Extremely lightweight and easy to use
  * only **one** class to `use`
  * dead simple API, which reads like English when you use good variable names
  * uses generators to produce randomized values which fulfill the given constraints
  * pragmatic: common use-cases already included like integers, integers within a range, strings, "garbage" data, etc.
    * but it's still easy to pass in your own generator if you know how they work
  * other than generators and callbacks, no use of "advanced" or "frameworky" features (there shall be no `Proposition\Interfaces\PropositionableIterators\PropositionableIteratorInterface`). Functional programming features may be useful here, but shall be used with care.
  * no packages in "require"
* Easy to integrate with PHPUnit but there should be NO functionality specific to that.
* Compatible with PHP v.7.0 and up but also v.5.6. Probably not below that.

## Status

Most core functionality and documentation is complete. The plan is to fix issue #1 and issue #3, make some PHPUnit tests which test it with itself, then release it on packagist.

Contributors are welcome!
