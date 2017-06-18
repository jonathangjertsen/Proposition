<?php
namespace Proposition;

use Generator;

class Proposition
{
    /** Default maximum number of tests to run. */
    const DEFAULT_MAX_TESTS = 100;

    /** @var int Maximum number of tests to run. */
    private $max_tests;

    /** @var Generator[] An array of generators representing a "given". */
    private $generators = [];

    /**
     * Construct a Proposition object.
     *
     * @param int $max_tests
     */
    public function __construct($max_tests = self::DEFAULT_MAX_TESTS)
    {
        $this->max_tests = (int)$max_tests;
    }

    /**
     * Add the given $generators to the list of generators which will be used to construct arguments.
     *
     * For example, if you pass ONE generator into given(), the $hypothesis that you pass into call($hypothesis) should
     * be a callable which takes a single argument. The value of that argument will be generated by the generator you
     * passed into $given. And if given() is called with TWO generators, the value of $hypothesis should take TWO
     * arguments: the value of the first argument is generated by the first generator, the value of the second argument
     * is generated by the second generator. And so on.
     *
     * You can of course call given() multiple times if you need to. The generators are simply appended one after the
     * other.
     *
     * @param Generator ...$generators which generate values.
     *
     * @return $this to allow chaining methods.
     */
    public function given(Generator ...$generators)
    {
        array_push($this->generators, ...$generators);

        return $this;
    }

    /**
     * Run the given $hypothesis function with values generated by whatever you passed into given(). Optionally return
     * an array containing the arguments that were passed into the $hypothesis, along with the value that $hypothesis
     * returned for those arguments.
     *
     * @param callable $hypothesis    A function which takes values generated by whatever you passed into given(), and
     *                                e.g. asserts that some property of those values always holds. The function can
     *                                return whatever you want.
     *
     * @param bool     $return_values Whether to store and return whatever $hypothesis returns.
     *
     * @return null|array             If $return_values is true, it will be an array of arrays with two entries:
     *                                'argument' and 'result'. Each 'arguments' is an array with the arguments that
     *                                Proposition tried to pass into the $hypothesis, and 'result' is whatever the
     *                                $hypothesis returned.
     */
    public function call(callable $hypothesis, $return_values = false)
    {
        $results = [];

        foreach ($this->generateArgumentLists() as $argument_list) {
            if ($return_values) {
                $results[] = [
                    'arguments' => $argument_list,
                    'result'    => $hypothesis(...$argument_list)
                ];
            } else {
                $hypothesis(...$argument_list);
            }
        }

        if ($return_values) {
            return $results;
        } else {
            return null;
        }
    }

    // The following are generators which can be passed into given(), covering common use-cases.

    /**
     * Generate literally any possible value from any of the other generators in this class. Mostly useful for input
     * validation.
     *
     * @return Generator
     * @throws \Exception
     */
    public static function anything()
    {
        /** @var string[] $methods The methods in this class that we will pick from. */
        $methods = ['integers', 'accidents', 'garbage', 'evilStrings'];

        /** @var Generator[] $existing_generators They need to be stored after we first generate them, so we can keep
         * track of their state. */
        $existing_generators = [];

        while (true)
        {
            // Pick a random generator.
            $chosen_method = $methods[rand(0, count($methods) - 1)];

            // Init the generator and store it.
            if (!array_key_exists($chosen_method, $existing_generators))
            {
                $existing_generators[$chosen_method] = self::$chosen_method();
            }

            // Yield its value.
            yield $existing_generators[$chosen_method]->current();

            // Iterate the generator for next time.
            $existing_generators[$chosen_method]->next();
        }
    }

    /**
     * Generate random integers of any size. Start out with small integers, then double the available range on each
     * iteration. After the range has maxed out, start over.
     *
     * @return Generator
     */
    public static function integers()
    {
        // First, make sure the most common numbers are covered.
        yield 0;
        yield -1;
        yield 1;

        // Then generate random numbers from an increasing range.
        $half_of_randmax = mt_getrandmax() / 2;
        $lim = 1;
        $iterations = 0;
        while (true) {
            $iterations++;

            yield mt_rand(-$lim, $lim);

            if ($lim <= $half_of_randmax) {
                $lim *= 2;
            } else {
                // Start over when maxed out.
                $lim = 1;
            }
        }
    }

    /**
     * Generate random integers within the closed interval [$min, $max], i.e. including $min and $max.
     *
     * @param int $min Lower limit of integers to include.
     * @param int $max Upper limit of integers to include.
     *
     * @return Generator
     * @throws \Exception
     */
    public static function integerRange($min, $max)
    {
        $min = (int)$min;
        $max = (int)$max;

        if ($min > $max) {
            throw new \Exception("Invalid integer range: \$max should be at least $min, but it was set to $max");
        }

        while (true) {
            yield mt_rand($min, $max);
        }
    }

    /**
     * Same as integers, just with floats. We use a much lower initial limit.
     *
     * @return Generator
     */
    public static function floats()
    {
        // First, make sure the most common numbers are covered.
        yield 0.0;
        yield -1.0;
        yield 1.0;

        // Then generate random numbers from an increasing range.
        $lim = 0.01;
        $iterations = 0;
        while (true) {
            $iterations++;

            yield $lim * (2 * mt_rand() / mt_getrandmax() - 1);

            if ($lim <= mt_getrandmax() / 2) {
                $lim *= 2;
            } else {
                // Start over when maxed out.
                $lim = 0.01;
            }
        }
    }

    /**
     * Same as integer range, just with floats.
     *
     * @param $min
     * @param $max
     *
     * @return Generator
     * @throws \Exception
     */
    public static function floatRange($min, $max)
    {
        $min = (float)$min;
        $max = (float)$max;

        if ($min > $max) {
            throw new \Exception("Invalid integer range: \$max should be at least $min, but it was set to $max");
        }

        while (true) {
            yield $min + mt_rand() / mt_getrandmax() * ($max - $min);
        }
    }

    /**
     * Generate random bools.
     *
     * @return Generator
     */
    public static function bools()
    {
        while (true) {
            yield !mt_rand(0,1);
        }
    }

    /**
     * Generate random ASCII characters.
     *
     * @param bool $extended Whether to use the extended ASCII codes.
     *
     * @return Generator
     */
    public static function chars($extended = false)
    {
        while (true) {
            yield chr(mt_rand(0, 128 * (1 + $extended) - 1));
        }
    }

    /**
     * Generate random letters, lowercase or uppercase.
     *
     * @return Generator
     */
    public static function letters()
    {
        while (true) {
            yield mt_rand(0, 1) ? chr(mt_rand(65,90)) : chr(mt_rand(97,122));
        }
    }

    /**
     * Generate random uppercase letters.
     *
     * @return Generator
     */
    public static function upperLetters()
    {
        while (true) {
            yield chr(mt_rand(65,90));
        }
    }

    /**
     * Generate random lowercase letters.
     *
     * @return Generator
     */
    public static function lowerLetters()
    {
        while (true) {
            yield chr(mt_rand(97,122));
        }
    }

    /**
     * Generate random ASCII strings with a maximum length of $max_len.
     *
     * @param      $max_len
     * @param bool $extended Whether to use the extended ASCII codes.
     *
     * @return Generator
     */
    public static function asciiStrings($max_len, $extended = false)
    {
        $generator = self::chars($extended);
        while (true) {
            yield self::stringsFromChars($max_len, $generator);
        }
    }

    /**
     * Generate random letter strings with a maximum length of $max_len.
     *
     * @param $max_len
     *
     * @return Generator
     */
    public static function letterStrings($max_len)
    {
        $generator = self::letters();
        while (true) {
            yield self::stringsFromChars($max_len, $generator);
        }
    }

    /**
     * Generate random uppercase letter strings with a maximum length of $max_len
     *
     * @param $max_len
     *
     * @return Generator
     */
    public static function upperLetterStrings($max_len)
    {
        $generator = self::upperLetters($max_len);
        while (true) {
            yield self::stringsFromChars($max_len, $generator);
        }
    }

    /**
     * Generate random lowercase letter strings with a maximum length of $max_len
     *
     * @param $max_len
     *
     * @return Generator
     */
    public static function lowerLetterStrings($max_len)
    {
        $generator = self::lowerLetters($max_len);
        while (true) {
            yield self::stringsFromChars($max_len, $generator);
        }
    }

    /**
     * Generate values chosen from the input array.
     *
     * @param array $input
     *
     * @return Generator
     */
    public static function chooseFrom(array $input)
    {
        $input = array_values($input);
        while (true) {
            yield $input[mt_rand(0, count($input) - 1)];
        }
    }

    /**
     * Generate values chosen from the input array, in order.
     *
     * @param array $input
     *
     * @return Generator
     */
    public static function cycleThrough(array $input)
    {
        while (true) {
            foreach ($input as $element) {
                yield $element;
            }
        }
    }

    /**
     * Generates some values that a function will typically return if something is wrong, like null or an empty array.
     * Good for handling common failure modes.
     *
     * @return Generator
     */
    public static function accidents()
    {
        while (true) {
            yield null;
            yield false;
            yield true;
            yield 0;
            yield [];
            yield "";
            yield new \stdClass();
        }
    }

    /**
     * Generate some weird values of all types. Mostly useful for input validation.
     *
     * @return Generator
     */
    public static function garbage()
    {
        while (true) {
            yield 0.1;
            yield mt_rand();
            yield -mt_rand();
            yield 0x48;
            yield "asdf";
            yield "någet Μη-ascii κείμενο";
            yield '\\\\\n\0';
            yield [1,2,3];
            yield ["@@@££€€€µµµ", null, new \stdClass(), [[]],[], '?' => ['r' => true, 4]];
            yield function () {};
            yield new \DateTime();
            yield new \Exception();
        }
    }

    /**
     * Generate evil strings, like those used for MySQL injection, XSS, etc.
     *
     * @return Generator
     */
    public static function evilStrings()
    {
        while (true) {
            yield "* WHERE 1=1; --";
            yield "<script>alert('xss')</script>";
        }
    }

    // The following are internal help functions.

    /**
     * The generator returned by this function will yield an argument list every time it is called, until the maximum
     * number of tests is reached. It does so by advancing each of the generators once and yielding, each iteration.
     *
     * @return Generator providing an argument list
     */
    private function generateArgumentLists()
    {
        for ($i = 0; $i < $this->max_tests; $i++) {
            $arg_list = [];

            foreach ($this->generators as &$generator) {
                $arg_list[] = $generator->current();
                $generator->next();
            }

            yield $arg_list;
        }
    }

    private static function stringsFromChars($max_len, Generator &$char_generator)
    {
        $ret = [];
        for ($i = 0, $max = mt_rand(0, $max_len); $i <= $max; $i++) {
            $ret[] = $char_generator->current();
            $char_generator->next();
        }
        return implode('', $ret);
    }
}
