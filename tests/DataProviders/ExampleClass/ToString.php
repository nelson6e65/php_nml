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

namespace NelsonMartell\Test\DataProviders\ExampleClass;

use NelsonMartell\IConvertibleToString;

/**
 * Example class to be used in PropertiesHandler test.
 * Not customized.
 *
 * Prefixes in member names:
 * 'property': using getter or setter;
 * 'attribute': direct access
 */
class ToString implements IConvertibleToString
{
    public function __construct()
    {
    }

    /**
     * @var int
     */
    public $x = -1;

    /**
     * @var int
     */
    public $y = 1;


    /**
     * @inheritDoc
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * @inheritDoc
     */
    public function toString()
    {
        return $this->x . ', ' . $this->y;
    }
}
