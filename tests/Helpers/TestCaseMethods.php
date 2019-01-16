<?php declare(strict_types=1);
/**
 * PHP: Nelson Martell Library file
 *
 * Copyright © 2016-2019 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright 2016-2019 Nelson Martell
 * @link      http://nelson6e65.github.io/php_nml/
 * @since     0.6.0
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

namespace NelsonMartell\Test\Helpers;

/**
 * Helper for traits used by TestCase classes.
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * @since 1.0.0
 * */
trait TestCaseMethods
{
    abstract public function addToAssertionCount(int $count) : void;
    abstract public function assertContains(
        $needle,
        $haystack,
        string $message = '',
        bool $ignoreCase = false,
        bool $checkForObjectIdentity = true,
        bool $checkForNonObjectIdentity = false
    ) : void;
    abstract public function assertEquals(
        $expected,
        $actual,
        string $message = '',
        float $delta = 0,
        int $maxDepth = 10,
        bool $canonicalize = false,
        bool $ignoreCase = false
    ) : void;
    abstract public function assertGreaterThan($expected, $actual, string $message = '') : void;
    abstract public function assertInstanceOf(string $expected, $actual, string $message = '') : void;
    abstract public function assertIsBool($actual, string $message = '') : void;
    abstract public function assertIsInt($actual, string $message = '') : void;
    abstract public function assertLessThan($expected, $actual, string $message = '') : void;
    abstract public function assertNull($actual, string $message = '') : void;
    abstract public function assertSame($expected, $actual, string $message = '') : void;
    abstract public function assertTrue($condition, string $message = '') : void;
    abstract public function expectException(string $exception) : void;
    abstract public function fail(string $message) : void;
}
