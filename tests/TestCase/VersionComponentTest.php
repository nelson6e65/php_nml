<?php

/**
 * PHP: Nelson Martell Library file
 *
 * Copyright © 2016-2020 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright 2016-2020 Nelson Martell
 * @link      http://nelson6e65.github.io/php_nml/
 * @since     v0.6.0
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

declare(strict_types=1);

namespace NelsonMartell\Test\TestCase;

use InvalidArgumentException;
use NelsonMartell\Extensions\Text;
use NelsonMartell\Test\DataProviders\VersionComponentTestProvider;
use NelsonMartell\VersionComponent;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass NelsonMartell\VersionComponent
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * @internal
 * */
class VersionComponentTest extends TestCase
{
    use VersionComponentTestProvider;

    public function getTargetClassName(): string
    {
        return VersionComponent::class;
    }

    /**
     * @testdox Performs conversion from compatible objects
     * @covers ::parse
     * @dataProvider goodVersionComponentParseMethodArgumentsProvider
     *
     * @param VersionComponent $expected
     * @param mixed            $obj
     */
    public function testParseMethod(VersionComponent $expected, $obj): void
    {
        $actual = VersionComponent::parse($obj);

        $message = Text::format(
            '{class}::{method}({obj}); // {actual}',
            [
                'class'  => VersionComponent::class,
                'method' => 'isValid',
                'obj'    => static::export($obj),
                'actual' => static::export($actual),
            ]
        );

        $this->assertEquals($expected, $actual, $message);
    }

    /**
     * @testdox Informs if error occurs on parsing incompatible objects
     * @covers ::parse
     * @dataProvider badVersionComponentParseMethodArgumentsProvider
     *
     * @param mixed $obj
     */
    public function testParseMethodWithInvalidArguments($obj): void
    {
        /** @var TestCase $this */
        $this->expectException(InvalidArgumentException::class);
        $actual = VersionComponent::parse($obj);
    }

    /**
     * @covers ::isNull
     * @covers ::isNotNull
     * @covers ::isDefault
     * @covers ::isNotDefault
     * @dataProvider nullOrDefaultStatesProvider
     *
     * @param string           $expected
     * @param VersionComponent $versionComponent
     */
    public function testCanCheckIfVersionComponentIsInDefaultOrNullState(
        string $expected,
        VersionComponent $versionComponent
    ): void {
        static $format = '$versionComponent->{method}(); // {actual}';

        $actuals['isDefault']    = $versionComponent->isDefault();
        $actuals['isNotDefault'] = $versionComponent->isNotDefault();
        $actuals['isNull']       = $versionComponent->isNull();
        $actuals['isNotNull']    = $versionComponent->isNotNull();

        $messages = [];

        foreach ($actuals as $method => $actual) {
            $messages[$method] = Text::format($format, ['method' => $method, 'actual' => static::export($actual)]);
        }

        foreach ($actuals as $method => $actual) {
            // Pre-tests for returning type
            $this->assertIsBool($actual, $messages[$method] . ' # Should return a boolean #');
        }

        // Pre-tests for different values
        $this->assertNotEquals(
            $actuals['isDefault'],
            $actuals['isNotDefault'],
            $messages['isDefault'] . PHP_EOL . $messages['isNotDefault']
        );

        $this->assertNotEquals(
            $actuals['isNull'],
            $actuals['isNotNull'],
            $messages['isNull'] . PHP_EOL . $messages['isNotNull']
        );


        // Test expected
        if ($expected === 'default') {
            $this->assertTrue($actuals['isDefault'], $messages['isDefault']);

            // Can't be null AND default
            $this->assertNotEquals(
                $actuals['isNull'],
                $actuals['isDefault'],
                '#Can\'t be both, DEFAULT and NULL, at the same time' . PHP_EOL .
                $messages['isDefault'] . PHP_EOL .
                $messages['isNull']
            );
        } elseif ($expected === 'null') {
            $this->assertTrue($actuals['isNull'], $messages['isNull']);

            // Can't be null AND default
            $this->assertNotEquals(
                $actuals['isNull'],
                $actuals['isDefault'],
                '#Can\'t be both, NULL and DEFAULT, at the same time' . PHP_EOL .
                $messages['isNull'] . PHP_EOL .
                $messages['isDefault']
            );
        } else {
            $this->assertTrue($actuals['isNotDefault'], $messages['isNotDefault']);
            $this->assertTrue($actuals['isNotNull'], $messages['isNotNull']);
        }
    }
}
