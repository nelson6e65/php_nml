<?php

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
 * @since     v0.6.0
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

declare(strict_types=1);

namespace NelsonMartell\Test\DataProviders;

use InvalidArgumentException;
use stdClass;
use TypeError;
use NelsonMartell\Test\Helpers\ConstructorMethodTester;
use NelsonMartell\Test\Helpers\ExporterPlugin;
use NelsonMartell\Test\Helpers\HasReadOnlyProperties;
use NelsonMartell\Test\Helpers\HasUnaccesibleProperties;
use NelsonMartell\Test\Helpers\IComparableTester;
use NelsonMartell\Test\Helpers\IComparerTester;
use NelsonMartell\Test\Helpers\IEquatableTester;
use NelsonMartell\Test\Helpers\ImplementsIConvertibleToString;
use NelsonMartell\Test\Helpers\ImplementsIStrictPropertiesContainer;
use NelsonMartell\Version;
use NelsonMartell\VersionComponent;

/**
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * @internal
 * */
trait VersionTestProvider
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

    public function unaccesiblePropertiesProvider()
    {
        $version = Version::parse(NML_VERSION);

        return [
            '$major with case changed'    => [$version, 'Major'],
            '$minor with case changed'    => [$version, 'Minor'],
            '$build with case changed'    => [$version, 'Build'],
            '$revision with case changed' => [$version, 'Revision'],
        ];
    }

    /**
     * Provides invalid arguments for constructor.
     *
     * @return array
     */
    public function badConstructorArgumentsProvider()
    {
        return [
            'Type: null (all)'               => [TypeError::class, null, null],
            'Only first argument'            => [TypeError::class, 1, null],
            'Invalid $major and $minor type' => [TypeError::class, 'hello', 'world'],
            'Invalid $major type (string)'   => [TypeError::class, 'hello', 1],
            'Invalid $minor type (string)'   => [TypeError::class, 1, 'world'],
            '$major value < 0'               => [InvalidArgumentException::class, -1, 0],
            '$minor value < 0'               => [InvalidArgumentException::class, 1, -3],
            '$build value < 0'               => [InvalidArgumentException::class, 1, 0, -1, null],
            '$revision value < 0'            => [InvalidArgumentException::class, 1, 0, 1, -1],
            '$revision while $build is not'  => [InvalidArgumentException::class, 1, 0, null, -1],
        ];
    }

    /**
     * Provides valid arguments for constructor.
     *
     * @return array
     */
    public function goodConstructorArgumentsProvider()
    {
        return [
            'SemVer: Normal'            => [1, 0, 0],
            'SemVer: Patch release '    => [1, 0, 1],
            'SemVer: Minor release'     => [1, 1, 0],
            'SemVer: Major release'     => [2, 0, 0],
            'SemVer: Pre-release alpha' => [1, 0, '0-alpha'],
            'SemVer: Pre-release beta'  => [1, 0, '0-beta', 1],
            // 'SemVer: Pre-release build metadata' => [1, 0, '0-beta', '1+20130313144700'],
            'Windows version: Major'    => [1, 0, 0, 0],
            'Windows version: Minor'    => [1, 1, 0, 0],
            'Windows version: Build'    => [1, 2, 1, 0],
            'Windows version: Revision' => [1, 3, 1, 2344234],
            'Git: describe'             => [0, 5, '1-34-g6e5462c'],
            'Zero (minor)'              => [0, 0], // is invalid, but can be created
            'Zero (build)'              => [0, 0, 0], // is invalid, but can be created
            'Zero (revision)'           => [0, 0, 0, 0], // is invalid, but can be created
        ];
    }


    public function objectInstanceProvider()
    {
        return [[new Version(0, 7, '0-beta')]];
    }

    public function readOnlyPropertiesProvider()
    {
        $obj = new Version(0, 7, '0-beta');

        return [
            [$obj, 'major', 0],
            [$obj, 'minor', 7],
            [$obj, 'build', new VersionComponent(0, '-beta')],
            [$obj, 'revision', new VersionComponent(null)],
        ];
    }

    public function IComparableCompareToMethodArgumentsProvider()
    {
        $v             = new Version(1, 0, 9);
        $obj           = new stdClass();
        $obj->major    = 1;
        $obj->minor    = 0;
        $obj->build    = 9;
        $obj->revision = null;


        $args = [
            'Equals by reference'            => [0, $v, $v],
            'Equals by value'                => [0, new Version(1, 0, 1), Version::parse('1.0.1')],
            'Major difference'               => [-1, Version::parse('1.0.0'), Version::parse('2.0.0')],
            'Minor difference'               => [1, Version::parse('1.1.0'), Version::parse('1.0.0')],
            'Build difference'               => [1, Version::parse('1.0.1'), Version::parse('1.0.0')],
            'Revision difference'            => [-1, Version::parse('1.0.0.254'), Version::parse('1.0.0.389')],
            'Version < object'               => [null, $v, $obj],
            'Version > array parseable'      => [1, Version::parse('1.1.0'), [0, 1, 999]],
            'Version < array parseable'      => [-1, Version::parse('1.1.0'), [2, 0]],
            'Version > array not parseable'  => [1, Version::parse('0.0.0'), ['invalid array']],
            'Version > string parseable'     => [1, Version::parse('1.1.0'), '0.1.999'],
            'Version < string parseable'     => [-1, Version::parse('1.1.0'), '2.0'],
            'Version > string not parseable' => [1, Version::parse('1.1.0'), 'invalid string'],
            'integer|Version'                => [1, $v, 9976645645656],
            'Version > null'                 => [1, Version::parse('1.1.0'), null],
        ];

        return $args;
    }

    public function compareMethodArgumentsProvider()
    {
        $v             = new Version(1, 0, 9);
        $obj           = new \stdClass();
        $obj->major    = 1;
        $obj->minor    = 0;
        $obj->build    = 9;
        $obj->revision = null;

        $args = [
            'stdClass|Version' => [null, $obj, $v],
            'string|Version'   => [-1, '1.0.0.254', $v],
            'integer|Version'  => [-1, 9976645645656, $v],
            'float|Version'    => [-1, 1.342333, $v],
            'array|Version'    => [-1, [0, 1, 999], Version::parse('1.1.0')],
        ];

        return $args;
    }

    public function compareMethodArraysProvider()
    {
        return [
            'Version[]'                                     => [[
                new Version(1, 0, 1, 3),
                new Version(1, 0, 11, 3),
                new Version(1, 1, 1, 0),
                new Version(1, 3, 1, 9),
                Version::parse('2.3.2-3-g'),
                Version::parse('2.3.2-3-g726356'),
                Version::parse('2.3.2-4-g'),
                Version::parse('2.3.4-3-g'),
                Version::parse('2.3.4-3-gsh4hajk7'),
                Version::parse('2.3.4-3-gsh4hbjk7'),
                Version::parse('2.31.0-4-g'),
                Version::parse('2.31.1-4-g'),
                Version::parse('2.31.11-4-g'),
            ],
            ],
            'Version[] + integer[]'                         => [[
                1,
                new Version(1, 0, 1, 3),
                new Version(1, 0, 11, 3),
                new Version(1, 1, 1, 0),
            ],
            ],
            'Version[] + string[]'                          => [[
                '0.0',
                new Version(0, 0, 9, 3),
                '0.1.0',
            ],
            ],
            'Version[] + string[] (1 non parseable string)' => [[
                '0.1.0',
                'invalid string',
                new Version(1, 0, 1, 3),
            ],
            ],
            'Version[] + array[]'                           => [[
                [],
                [0, 1, 0],
                new Version(1, 0, 1, 3),
            ],
            ],
        ];
    }

    public function IEquatableMethodArgumentsProvider()
    {
        return [
            [true, new Version(1, 2), new Version(1, 2)],
            [false, new Version(1, 4), new Version(1, 2)],
            [false, new Version(1, 2, 1), new Version(1, 2, 2)],
            [false, new Version(1, 2, 1), 123],
            [false, new Version(1, 2, 1), 2345654675675675673453],
            [false, new Version(1, 2, 1), '1.2.1'],
            [false, new Version(1, 2, 1), [1, 2, 1]],
            [false, new Version(1, 2, 1), new \stdClass()],
        ];
    }

    protected $parseableStrings = [
        'valid'   => [
            '1.0',
            '0.2',
            '2.3.2-3-g726351',
            '2.3.2.3-2-g726352',
            '3.0.1',
            '4.0.2.0',
            '5.0.0.3-beta',
            '6.0.0-alpha',
            NML_VERSION,
        ],
        'invalid' => [
            '0.0',
            '1.0..1',
            '2.0.0-alpha.0',
            '2.3.2-3-g726353.3',
            '2.3.2-3-g726356.1-2-gyt4f4',
            '3.0.1-alpha.1',
            '4.0.0-alpha.0-beta',
            '5.0.1-alpha.2-beta',
        ],
    ];

    public function isValidProvider()
    {
        $args = [];

        foreach ($this->parseableStrings['valid'] as $str) {
            $args[$str] = [true, Version::parse($str)];
        }

        foreach ($this->parseableStrings['invalid'] as $str) {
            $args[$str] = [false, Version::parse($str)];
        }

        return $args;
    }


    public function parseableStringsProvider(): array
    {
        $strings = [
            NML_VERSION,
            '1.0',
            '0.2',
            '2.3.2-3-g726351',
            '2.3.2.3-2-g726352',
            '3.0.1',
            '4.0.2.0',
            '5.0.0.3-beta',
            '6.0.0-alpha',

            // Invalid?
            '0.0',
            '1.0..1',
            '2.0.0-alpha.0',
            '2.3.2-3-g726353.3',
            '2.3.2-3-g726356.1-2-gyt4f4',
            '3.0.1-alpha.1',
            '4.0.0-alpha.0-beta',
            '5.0.1-alpha.2-beta',
        ];

        $r = [];

        foreach ($strings as $str) {
            $r[$str] = [$str];
        }

        return $r;
    }

    public function parseableArraysProvider(): array
    {
        return [
            'minimum version'  => [[1, 0]],
            'build version'    => [[1, 1, 2]],
            'revision version' => [[1, 0, '0-beta', 3]],
        ];
    }

    public function nonParseableValuesProvider()
    {
        return [
            'empty string'              => [''],
            'empty array'               => [[]],
            'array with only 1 element' => [[1]],
        ];
    }

    public function toStringProvider()
    {
        return [
            ['1.0', new Version(1, 0)],
            ['0.2', new Version(0, 2)],
            ['2.3.2-3-g726351', new Version(2, 3, '2-3-g726351')],
            ['2.3.2.3-2-g726352', new Version(2, 3, 2, '3-2-g726352')],
            ['3.0.1', new Version(3, 0, 1)],
            ['4.0.2.0', new Version(4, 0, 2, 0)],
            ['5.0.0.3-beta', new Version(5, 0, 0, '3-beta')],
            ['6.0.0-alpha', new Version(6, 0, '0-alpha')],
        ];
    }
}
