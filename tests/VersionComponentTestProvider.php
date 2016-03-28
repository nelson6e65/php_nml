<?php
/**
 * PHP: Nelson Martell Library file
 *
 * Content:
 * - Trait definition.
 *
 * Copyright © 2016 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright 2016 Nelson Martell
 * @link      http://nelson6e65.github.io/php_nml/
 * @since     v0.6.0
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

namespace NelsonMartell\Test;

use NelsonMartell as NML;
use NelsonMartell\VersionComponent;
use NelsonMartell\Extensions\String;
use \InvalidArgumentException;

/**
 * Data providers for NelsonMartell\Test\VersionComponent.
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * @internal
 * */
trait VersionComponentTestProvider
{
    public function goodConstructorArgumentsProvider()
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

    public function badConstructorArgumentsProvider()
    {
        return [
            'Negative integer part'        => [-1, null],
            'Invalid string value part'    => [0, 'erróneo'],
            'Invalid type (float) for string part'  => [0, 23.912],
            'Invalid type (object) for string part'  => [0, new \stdClass],
            'Invalid type (array) for string part'  => [0, ['no']],
        ];
    }

    public function IComparableCompareToMethodArgumentsProvider()
    {
        $v = new VersionComponent(1, '-alpha');
        $obj = new \stdClass();
        $obj->intValue = 1;
        $obj->stringValue = '-alpha';

        $args = [
            'Equals by reference' => [0, $v, $v],
            'Equals by value'     => [
                0,
                new VersionComponent(1, '-alpha'),
                VersionComponent::parse('1-alpha')
            ],
            'VersionComponent: >' => [
                1,
                new VersionComponent(1, '-beta'),
                VersionComponent::parse('1-alpha')
            ],
            'VersionComponent: <' => [
                -1,
                new VersionComponent(1, '-alpha'),
                VersionComponent::parse('1-beta')
            ],
            'VersionComponent | stdClass: null' => [
                null,
                $v,
                $obj
            ],
        ];

        return $args;
    }


    public function IComparableCompareMethodArgumentsProvider()
    {
        $v = new VersionComponent(1, '-alpha');
        $obj = new \stdClass();
        $obj->intValue = 1;
        $obj->stringValue = '-alpha';

        return [
            [-1, 'array', $v],
            [null, $v, $obj],
            [-1, [], $v],
        ];
    }

    public function IComparableCompareMethodArraysProvider()
    {
        return [
            'VersionComponent[]' => [[
                VersionComponent::parse("0-4-g"),
                VersionComponent::parse("1-4-g"),
                VersionComponent::parse("2-3-g"),
                VersionComponent::parse("2-3-g726356"),
                VersionComponent::parse("2-4-g"),
                VersionComponent::parse("4-3-g"),
                VersionComponent::parse("4-3-gsh4hajk7"),
                VersionComponent::parse("4-3-gsh4hbjk7"),
                VersionComponent::parse("11-4-g"),
            ]],
            'VersionComponent[] + integer[]' => [[
                1,
                new VersionComponent(2, '-alpha'),
            ]],
            'VersionComponent[] + string[]'  => [[
                new VersionComponent(1, '-alpha'),
                '1-beta',
            ]],
            'VersionComponent[] + string[] (non parseable)'  => [[
                '----------',
                new VersionComponent(),
            ]],
            'VersionComponent[] + array[]'   => [[
                [],
                [0, 1, 0],
                new VersionComponent(1, '-alpha'),
            ]],
        ];
    }

    public function goodVersionComponentParseMethodArgumentsProvider()
    {
        return [
            [new VersionComponent(1, 'a0'), '1a0'],
            [new VersionComponent(2, '-3-g726351'), '2-3-g726351'],
            [new VersionComponent(3, '-beta'), '3-beta'],
            [new VersionComponent(0, '-alpha'), '0-alpha'],
            [new VersionComponent(0, '-beta2'), '0-beta2'],
            'string | empty'        => [new VersionComponent(), '      '], // Maybe should throw exception?
            'string | only spaces'  => [new VersionComponent(), ''], // Maybe should throw exception?
            'null'                  => [new VersionComponent(), null], // Maybe should throw exception?
            'integer'               => [new VersionComponent(7), 7],
            'VersionComponent'      => [new VersionComponent(999), new VersionComponent(999)],
        ];
    }

    public function badVersionComponentParseMethodArgumentsProvider()
    {
        return [
            'string | consecutive "-"'          => ['1a--0'],
            'string | invalid char: ó'          => ['1-erróneo'],
            'string | not starting in number'   => ['beta0'],
            'integer | < 0'                     => [-13],
            'stdClass'                          => [new \stdClass],
        ];
    }

    public function versionComponentToStringMethodArgumentsProvider()
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
            ['2-rc1-20-g8c5b85c', new VersionComponent(2, "-rc1-20-g8c5b85c")],
        ];
    }
}
