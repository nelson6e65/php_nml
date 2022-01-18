<?php

/**
 * PHP: Nelson Martell Library file
 *
 * Copyright © 2016-2021 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright 2016-2021 Nelson Martell
 * @link      http://nelson6e65.github.io/php_nml/
 * @since     0.6.0
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

declare(strict_types=1);

namespace NelsonMartell\Test\DataProviders;

use stdClass;
use InvalidArgumentException;
use NelsonMartell\Test\Helpers\ConstructorMethodTester;
use NelsonMartell\Test\Helpers\ExporterPlugin;
use NelsonMartell\Test\Helpers\HasReadOnlyProperties;
use NelsonMartell\Test\Helpers\HasUnaccesibleProperties;
use NelsonMartell\Test\Helpers\IComparableTester;
use NelsonMartell\Test\Helpers\IComparerTester;
use NelsonMartell\Test\Helpers\IEquatableTester;
use NelsonMartell\Test\Helpers\ImplementsIConvertibleToString;
use NelsonMartell\Test\Helpers\ImplementsIStrictPropertiesContainer;
use NelsonMartell\VersionComponent;

/**
 * Data providers for NelsonMartell\Test\VersionComponent.
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * @since 0.6.0
 *
 * @internal
 * */
trait VersionComponentTestProvider
{
    use ConstructorMethodTester;
    use ExporterPlugin;
    use HasReadOnlyProperties;
    use HasUnaccesibleProperties;
    use IComparableTester;
    use IComparerTester;
    use IEquatableTester;
    use ImplementsIConvertibleToString;
    use ImplementsIStrictPropertiesContainer;

    public function unaccesiblePropertiesProvider(): array
    {
        $obj = new VersionComponent(null, 'beta');

        return [
            '$stringValue with case changed' => [$obj, 'StringValue'],
            '$intValue with case changed'    => [$obj, 'IntValue'],
        ];
    }

    public function goodConstructorArgumentsProvider(): array
    {
        return [
            'No args'           => [],
            'null values'       => [null, null],
            'Only integer part' => [1, null],
            'Only string part'  => [null, '-alpha'],
            'All arguments'     => [5, '-beta'],
            'Git describe'      => [19, '-g7575872'],
        ];
    }

    public function badConstructorArgumentsProvider(): array
    {
        return [
            'Negative integer part'                 => [InvalidArgumentException::class, -1, null],
            'Invalid string value part'             => [InvalidArgumentException::class, 0, 'erróneo'],
            'Invalid type (float) for string part'  => [InvalidArgumentException::class, 0, 23.912],
            'Invalid type (object) for string part' => [InvalidArgumentException::class, 0, new stdClass()],
            'Invalid type (array) for string part'  => [InvalidArgumentException::class, 0, ['no']],
        ];
    }

    public function objectInstanceProvider(): array
    {
        return [[new VersionComponent(1, '-beta')]];
    }

    public function readOnlyPropertiesProvider(): array
    {
        $obj = new VersionComponent(1, '-beta');

        return [
            [$obj, 'intValue', 1],
            [$obj, 'stringValue', '-beta'],
        ];
    }

    public function IComparableCompareToMethodArgumentsProvider(): array
    {
        $v                = new VersionComponent(1, '-alpha');
        $obj              = new stdClass();
        $obj->intValue    = 1;
        $obj->stringValue = '-alpha';

        $args = [
            'Equals by reference'                        => [0, $v, $v],
            'Equals by value'                            => [
                0,
                new VersionComponent(1, '-alpha'),
                VersionComponent::parse('1-alpha'),
            ],
            'VersionComponent: >'                        => [
                1,
                new VersionComponent(1, '-beta'),
                VersionComponent::parse('1-alpha'),
            ],
            'VersionComponent: <'                        => [
                -1,
                new VersionComponent(1, '-alpha'),
                VersionComponent::parse('1-beta'),
            ],
            'VersionComponent | stdClass: null'          => [
                null,
                $v,
                $obj,
            ],
            'VersionComponent | null'                    => [
                1,
                $v,
                null,
            ],
            'VersionComponent | VersionComponent (null)' => [
                -1,
                new VersionComponent(),
                new VersionComponent(1),
            ],
        ];

        return $args;
    }


    public function compareMethodArgumentsProvider(): array
    {
        $v                = new VersionComponent(1, '-alpha');
        $obj              = new stdClass();
        $obj->intValue    = 1;
        $obj->stringValue = '-alpha';

        return [
            [-1, 'array', $v],
            [null, $v, $obj],
            [-1, [], $v],
        ];
    }

    public function compareMethodArraysProvider(): array
    {
        return [
            'VersionComponent[]'                            => [[
                VersionComponent::parse('0-4-g'),
                VersionComponent::parse('1-4-g'),
                VersionComponent::parse('2-3-g'),
                VersionComponent::parse('2-3-g726356'),
                VersionComponent::parse('2-4-g'),
                VersionComponent::parse('4-3-g'),
                VersionComponent::parse('4-3-gsh4hajk7'),
                VersionComponent::parse('4-3-gsh4hbjk7'),
                VersionComponent::parse('11-4-g'),
            ],
            ],
            'VersionComponent[] + integer[]'                => [[
                1,
                new VersionComponent(2, '-alpha'),
            ],
            ],
            'VersionComponent[] + string[]'                 => [[
                new VersionComponent(1, '-alpha'),
                '1-beta',
            ],
            ],
            'VersionComponent[] + string[] (non parseable)' => [[
                '----------',
                new VersionComponent(),
            ],
            ],
            'VersionComponent[] + array[]'                  => [[
                [],
                [0, 1, 0],
                new VersionComponent(1, '-alpha'),
            ],
            ],
        ];
    }

    public function goodVersionComponentParseMethodArgumentsProvider(): array
    {
        return [
            [new VersionComponent(1, 'a0'), '1a0'],
            [new VersionComponent(2, '-3-g726351'), '2-3-g726351'],
            [new VersionComponent(3, '-beta'), '3-beta'],
            [new VersionComponent(0, '-alpha'), '0-alpha'],
            [new VersionComponent(0, '-beta2'), '0-beta2'],
            'string | empty'       => [new VersionComponent(), '      '], // Maybe should throw exception?
            'string | only spaces' => [new VersionComponent(), ''], // Maybe should throw exception?
            'null'                 => [new VersionComponent(), null], // Maybe should throw exception?
            'integer'              => [new VersionComponent(7), 7],
            'VersionComponent'     => [new VersionComponent(999), new VersionComponent(999)],
        ];
    }

    public function badVersionComponentParseMethodArgumentsProvider(): array
    {
        return [
            'string | consecutive "-"'        => ['1a--0'],
            'string | invalid char: ó'        => ['1-erróneo'],
            'string | not starting in number' => ['beta0'],
            'integer | < 0'                   => [-13],
            'stdClass'                        => [new stdClass()],
        ];
    }

    public function IEquatableMethodArgumentsProvider(): array
    {
        return [
            [true, new VersionComponent(1, '-alpha'), new VersionComponent(1, '-alpha')],
            [false, new VersionComponent(1, '-beta'), new VersionComponent(1, '-bet')],
            [false, new VersionComponent(3, '-dev'), new VersionComponent(1, '-dev')],
            [false, new VersionComponent(), null],
            [false, new VersionComponent(0), 0],
            [false, new VersionComponent(2), 2],
            [false, new VersionComponent(23), 2345654675675675673453],
            [false, new VersionComponent(0, '-dev'), '0-dev'],
            [false, new VersionComponent(1, '-alpha'), [1, '-alpha']],
            [false, new VersionComponent(), new stdClass()],
        ];
    }

    public function toStringProvider(): array
    {
        return [
            ['0', new VersionComponent(0)],
            ['', new VersionComponent()],
            ['', new VersionComponent(null, '')],
            ['', new VersionComponent(null, '  ')],
            ['', new VersionComponent(null)],
            ['', new VersionComponent(null, null)],
            ['1a', new VersionComponent(1, 'a')],
            ['1-beta', new VersionComponent(1, '-beta')],
            ['2-rc1-20-g8c5b85c', new VersionComponent(2, '-rc1-20-g8c5b85c')],
        ];
    }


    public function nullOrDefaultStatesProvider(): array
    {
        return [
            ['default', new VersionComponent(0)],
            ['null', new VersionComponent()],
            ['null', new VersionComponent(null, '')],
            ['null', new VersionComponent(null, '  ')],
            ['null', new VersionComponent(null)],
            ['null', new VersionComponent(null, null)],
            ['defined', new VersionComponent(1, 'a')],
            ['defined', new VersionComponent(1, '-beta')],
            ['defined', new VersionComponent(2, '-rc1-20-g8c5b85c')],
        ];
    }
}
