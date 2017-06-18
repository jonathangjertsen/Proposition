# Proposition
Lightweight property-based testing library for PHP. Inspired by Python's Hypothesis library.

## Installation

Because the API is not fully stable yet, you must specify dev-master to composer install:

    composer install jonathrg/proposition:dev-master

## What is property-based testing?

According to [the first blog post I found about it](http://blog.jessitron.com/2013/04/property-based-testing-what-is-it.html),

> Property-based tests make statements about the output of your code based on the input, and these statements are
verified for many different possible inputs. A property-based testing framework runs the same test over and over
with generated input.

This is in contrast to example-based testing, where you have to hand-write your inputs. A property-based testing library
like Proposition lets you test your code with thousands and thousands of input combinations (including all sorts of edge
 cases) with just a few lines of code. As an example, Proposition uses itself to test itself, and does so with about
 4000 assertions per line of test code.

## Documentation

See the [Wiki](https://github.com/jonathangjertsen/Proposition/wiki), especially the [Quick reference](https://github.com/jonathangjertsen/Proposition/wiki/Quick-Reference)

## Example usage

There are some examples of the values Proposition generates in the `examples` folder. Run them with PHP from the command line (see the readme.md there)

Here's a toy example showing how you would use Proposition to check whether your awesome reimplementation of `abs($a) == abs($b)` actually works.

    use Proposition/Proposition;

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
  * You only need to `use` **one** class.
    * A simple trait for PHPUnit tests may be included in the future.
  * Dead simple API, which reads like English when you use good variable names.
  * Uses generators to produce randomized values which fulfill the given constraints.
  * Pragmatic: common use-cases already included like integers, integers within a range, strings, "garbage" data, etc.
    * But we do not need generators for every possible use-case. You are free to transform your values however you want in the callback to `call`, and you can use the `Proposition::stream()` method to generate values your own way.
  * Other than generators and callbacks, no use of "advanced" or "frameworky" features (there shall be no `Proposition\Interfaces\PropositionableIterators\PropositionableIteratorInterface`).
  * no packages in "require"
* Easy to integrate with PHPUnit but there should be NO functionality specific to that in the main `Proposition` class.
* Compatible with PHP v.7.0 and up but also v.5.6. Probably not below that.

## Status

Most core functionality and documentation is complete. The plan is to fix issue #1 and issue #3, make some PHPUnit tests which test it with itself, then release it on packagist.

Contributors are welcome!
