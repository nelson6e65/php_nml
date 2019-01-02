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

use NelsonMartell\PropertiesHandler;
use NelsonMartell\IStrictPropertiesContainer;

/**
 * Example class to be used in PropertiesHandler test.
 * Not customized.
 *
 * Prefixes in member names:
 * 'property': using getter or setter;
 * 'attribute': direct access
 */
class A implements IStrictPropertiesContainer
{
    use PropertiesHandler;

    public function __construct()
    {
        // Unset the wrappers
        unset(
            $this->property1,
            $this->property3
        );
    }

    /**
     * This should not be accesible from external or inherited clases.
     * @var [type]
     */
    private $attribute1 = -1;
    public $property1;

    public function getProperty1()
    {
        return $this->attribute1;
    }

    protected $attribute2 = -2;

    public function getAttribute2()
    {
        // Only from external will use this getter
        return $this->attribute2;
    }

    private $attribute3 = -3;
    private $property3;

    public function getProperty3()
    {
        return $this->attribute3;
    }

    public function setProperty3($value)
    {
        $this->attribute3 = $value * 100;
    }

    protected $attribute4 = -4;
}
