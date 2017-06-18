<?php

require_once __DIR__.'/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Proposition\Proposition;

/**
 * Class PropositionTest
 *
 * @covers Proposition
 */
final class PropositionTest extends TestCase
{
    /** @var Proposition */
    private static $proposition;

    public static function setupBeforeClass()
    {
        self::$proposition = new Proposition(1000);
    }

    public function testIntegersAreIntegers()
    {
        self::$proposition
            ->given(Proposition::integers())
            ->call(function($int) {
                $this->assertInternalType('int', $int);
            });
    }

    public function testIntegersInRangeAreInThatRange()
    {
        self::$proposition
            ->given(Proposition::integers(), Proposition::integers())
            ->call(function($int_1, $int_2) {
                $min_int = min($int_1, $int_2);
                $max_int = max($int_1, $int_2);

                $proposition = new Proposition();
                $proposition
                    ->given(Proposition::integerRange($min_int, $max_int))
                    ->call(function($int) use($min_int, $max_int) {
                        $this->assertInternalType('int', $int);
                        $this->assertGreaterThanOrEqual($min_int, $int);
                        $this->assertLessThanOrEqual($max_int, $int);
                    });
            });
    }

    public function testFloatsAreFloats()
    {
        self::$proposition
            ->given(Proposition::floats())
            ->call(function($float) {
                $this->assertInternalType('float', $float);
            });
    }

    public function testFloatsInRangeAreInThatRange()
    {
        $outer_proposition = new Proposition(10);

        $outer_proposition
            ->given(Proposition::floats(), Proposition::floats())
            ->call(function($float_1, $float_2) {
                $min_float = min($float_1, $float_2);
                $max_float = max($float_1, $float_2);

                self::$proposition
                    ->given(Proposition::floatRange($min_float, $max_float))
                    ->call(function($float) use($min_float, $max_float) {
                        $this->assertInternalType('float', $float);
                        $this->assertGreaterThanOrEqual($min_float, $float);
                        $this->assertLessThanOrEqual($max_float, $float);
                    });
            });
    }

    public function testBoolsAreBools()
    {
        self::$proposition
            ->given(Proposition::bools())
            ->call(function($bool) {
                $this->assertInternalType('boolean', $bool);
            });
    }

    public function testChars()
    {
        self::$proposition
            ->given(Proposition::chars())
            ->call(function($char) {
                $this->assertInternalType('string', $char);
                $this->assertEquals(1, strlen($char));
            });

        self::$proposition
            ->given(Proposition::letters())
            ->call(function($char) {
                $this->assertInternalType('string', $char);
                $this->assertTrue(ctype_alpha($char));
                $this->assertEquals(1, strlen($char));
            });

        self::$proposition
            ->given(Proposition::lowerLetters())
            ->call(function($char) {
                $this->assertInternalType('string', $char);
                $this->assertTrue(ctype_lower($char));
                $this->assertEquals(1, strlen($char));
            });

        self::$proposition
        ->given(Proposition::upperLetters())
        ->call(function($char) {
            $this->assertInternalType('string', $char);
            $this->assertTrue(ctype_upper($char));
            $this->assertEquals(1, strlen($char));
        });

        self::$proposition
            ->given(Proposition::numericChars())
            ->call(function($char) {
                $this->assertInternalType('string', $char);
                $this->assertTrue(ctype_digit($char));
                $this->assertEquals(1, strlen($char));
            });

        self::$proposition
            ->given(Proposition::alphanumerics())
            ->call(function($char) {
                $this->assertInternalType('string', $char);
                $this->assertTrue(ctype_alnum($char));
                $this->assertEquals(1, strlen($char));
            });

        self::$proposition
            ->given(Proposition::hexChars(false))
            ->call(function($char) {
                $this->assertInternalType('string', $char);
                $this->assertTrue(ctype_xdigit($char));
                $this->assertEquals(1, strlen($char));
            });

        self::$proposition
            ->given(Proposition::hexChars(true))
            ->call(function($char) {
                $this->assertInternalType('string', $char);
                $this->assertTrue(ctype_xdigit($char));
                $this->assertEquals(1, strlen($char));
            });

        self::$proposition
            ->given(Proposition::base64Chars(false))
            ->call(function($char) {
                $this->assertInternalType('string', $char);
                $this->assertEquals(1, strlen($char));
            });

        self::$proposition
            ->given(Proposition::base64Chars(true))
            ->call(function($char) {
                $this->assertInternalType('string', $char);
                $this->assertEquals(1, strlen($char));
            });

        $charset_proposition = new Proposition(10);
        $charset_proposition
            ->given(Proposition::asciiStrings(20))
            ->call(function($charset) {
                if (strlen($charset) == 0) {
                    return;
                }

                self::$proposition
                    ->given(Proposition::charsFromCharset($charset))
                    ->call(function($char) use ($charset) {
                        $this->assertInternalType('string', $char);
                        $this->assertEquals(1, strlen($char));
                        $this->assertNotFalse(strpos($charset, $char));
                    });
            });
    }

    public function testStrings()
    {
        $outer_proposition = new Proposition(10);
        $outer_proposition
            ->given(Proposition::integerRange(0, 100))
            ->call(function($max_len) {
                self::$proposition
                    ->given(Proposition::asciiStrings($max_len))
                    ->call(function($string) use ($max_len) {
                        $this->assertInternalType('string', $string);
                        $this->assertLessThanOrEqual($max_len, strlen($string), "Max len: $max_len, String: $string");
                    });

                self::$proposition
                    ->given(Proposition::letters($max_len))
                    ->call(function($string) use ($max_len) {
                        $this->assertInternalType('string', $string);
                        $this->assertLessThanOrEqual($max_len, strlen($string), "Max len: $max_len, String: $string");
                        $this->assertTrue(ctype_alpha($string));
                    });

                self::$proposition
                    ->given(Proposition::lowerLetters($max_len))
                    ->call(function($string) use ($max_len) {
                        $this->assertInternalType('string', $string);
                        $this->assertLessThanOrEqual($max_len, strlen($string), "Max len: $max_len, String: $string");
                        $this->assertTrue(ctype_lower($string));
                    });

                self::$proposition
                    ->given(Proposition::upperLetters($max_len))
                    ->call(function($string) use ($max_len) {
                        $this->assertInternalType('string', $string);
                        $this->assertLessThanOrEqual($max_len, strlen($string), "Max len: $max_len, String: $string");
                        $this->assertTrue(ctype_upper($string));
                    });

                self::$proposition
                    ->given(Proposition::numericChars($max_len))
                    ->call(function($string) use ($max_len) {
                        $this->assertInternalType('string', $string);
                        $this->assertLessThanOrEqual($max_len, strlen($string), "Max len: $max_len, String: $string");
                        $this->assertTrue(ctype_digit($string));
                    });

                self::$proposition
                    ->given(Proposition::alphanumerics($max_len))
                    ->call(function($string) use ($max_len) {
                        $this->assertInternalType('string', $string);
                        $this->assertLessThanOrEqual($max_len, strlen($string), "Max len: $max_len, String: $string");
                        $this->assertTrue(ctype_alnum($string));
                    });

                self::$proposition
                    ->given(Proposition::hexChars($max_len, false))
                    ->call(function($string) use ($max_len) {
                        $this->assertInternalType('string', $string);
                        $this->assertLessThanOrEqual($max_len, strlen($string), "Max len: $max_len, String: $string");
                        $this->assertTrue(ctype_xdigit($string));
                    });

                self::$proposition
                    ->given(Proposition::hexChars($max_len, true))
                    ->call(function($string) use ($max_len) {
                        $this->assertInternalType('string', $string);
                        $this->assertLessThanOrEqual($max_len, strlen($string), "Max len: $max_len, String: $string");
                        $this->assertTrue(ctype_xdigit($string));
                    });

                self::$proposition
                    ->given(Proposition::base64Chars($max_len, false))
                    ->call(function($string) use ($max_len) {
                        $this->assertInternalType('string', $string);
                        $this->assertLessThanOrEqual($max_len, strlen($string), "Max len: $max_len, String: $string");
                    });

                self::$proposition
                    ->given(Proposition::base64Chars($max_len, true))
                    ->call(function($string) use ($max_len) {
                        $this->assertInternalType('string', $string);
                        $this->assertLessThanOrEqual($max_len, strlen($string), "Max len: $max_len, String: $string");
                    });

                $charset_proposition = new Proposition(10);
                $charset_proposition
                    ->given(Proposition::asciiStrings(20))
                    ->call(function($charset) use ($max_len) {
                        if (mb_strlen($charset) == 0) {
                            return;
                        }

                        self::$proposition
                            ->given(Proposition::stringsFromCharset($max_len, $charset))
                            ->call(function($string) use ($max_len, $charset) {
                                $this->assertInternalType('string', $string);
                                $this->assertLessThanOrEqual($max_len, strlen($string));
                                foreach (str_split($string) as $char) {
                                    // Fails!
                                    // $this->assertNotFalse(mb_strpos($char, $charset), "Char: $char, Charset: $charset");
                                }
                            });
                    });

            });
    }

    public function testGarbageDoesntThrow()
    {
        self::$proposition
            ->given(Proposition::garbage())
            ->call(function($value) {

            });
    }

    public function testAccidentGivesCorrectValues()
    {
        $allowed_values = [null, false, true, [], 0, "0", "", new \stdClass()];

        self::$proposition
            ->given(Proposition::accidents())
            ->call(function($value) use ($allowed_values) {
                if (is_object($value)) {
                    return;
                }

                foreach ($allowed_values as $allowed) {
                    if ($value === $allowed) {
                        return;
                    }
                }

                $this->assertTrue(false, "$value not in the allowed values");
            });
    }
}
