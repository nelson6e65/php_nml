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

namespace NelsonMartell\Test\TestCase;

use NelsonMartell\Extensions\Text;

use NelsonMartell\Test\DataProviders\VersionTestProvider;

use NelsonMartell\Version;

use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass NelsonMartell\Version
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * @internal
 * @since 0.6.0
 * */
class VersionTest extends TestCase
{
    use VersionTestProvider;

    public function getTargetClassName()
    {
        return Version::class;
    }

    /**
     * @depends NelsonMartell\Test\TestCase\VersionComponentTest::testParseMethod
     */
    public function testPerformsConversionFromString()
    {
        // Test for array ['invalid', 'array']
        $this->markTestIncomplete(
            'Tests for "'.Version::class.'::parse'.'" has not been completed yet.'
        );
    }


    /**
     * @testdox Can check if Version instance is valid
     * @dataProvider isValidProvider
     *
     * @param  bool    $expected [description]
     * @param  Version $version  [description]
     */
    public function testIsValid(bool $expected, Version $version) : void
    {
        $actual = $version->isValid();

        $message = Text::format(
            '$version->{method}(); // {actual}',
            [
                'method' => 'isValid',
                'obj'    => static::export($version),
                'actual' => static::export($actual)
            ]
        );

        $this->assertIsBool($actual, $message.' # Should return a boolean #');

        if ($expected === true) {
            $this->assertTrue($actual, $message);
        } else {
            $this->assertFalse($actual, $message);
        }
    }
}
