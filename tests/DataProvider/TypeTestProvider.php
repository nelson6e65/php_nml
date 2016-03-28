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
use NelsonMartell\Object;
use NelsonMartell\Extensions\String;
use NelsonMartell\Test\plugins\ExporterPlugin;
use \InvalidArgumentException;

/**
 * Data providers for NelsonMartell\Test\TypeTest.
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * @internal
 * */
trait TypeTestProvider
{

    /**
     * Provides valid arguments for constructor.
     *
     * @return array
     */
    public function goodConstructorArgumentsProvider()
    {
        return [
            'NULL'        => [null],
            'integer'     => [1],
            'double'      => [1.9999],
            'string'      => ['str'],
            'array'       => [[]],
            'stdClass'    => [new \stdClass],
            __CLASS__     => [$this],
        ];
    }

    public function toStringCheckProvider()
    {
        return [
            'NULL'          => ['NULL', null],
            'integer'       => ['integer', 1],
            'double'        => ['double', 1.9999],
            'string'        => ['string', 'str'],
            'array'         => ['array', []],
            'stdClass'      => ['object (stdClass)', new \stdClass],
            __CLASS__       => ['object (NelsonMartell\Test\TypeTest)', $this],
        ];
    }

    public function badConstructorArgumentsProvider()
    {
        return [[]];
    }
}
