<?php
/**
 * PHP: Nelson Martell Library file
 *
 * Content:
 * - Test case for: NelsonMartell\PropertiesHandler
 *
 * Copyright © 2016-2017 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright 2016-2017 Nelson Martell
 * @link      http://nelson6e65.github.io/php_nml/
 * @since     v0.6.0
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

namespace NelsonMartell\Test\TestCase;

use NelsonMartell as NML;
use NelsonMartell\Type;
use NelsonMartell\Extensions\String;
use NelsonMartell\Test\DataProviders\PropertiesHandlerTestProvider;
use \PHPUnit_Framework_TestCase as TestCase;
use \InvalidArgumentException;
use \BadMethodCallException;

/**
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * @internal
 * */
class PropertiesHandlerTest extends TestCase
{
    use PropertiesHandlerTestProvider;

    /**
     * @testdox Uses getters and setters methods in order to access and set values to class properties
     * @dataProvider getAccesiblePropertiesProvider
     */
    public function testGetAccesibleProperties($expected, $obj, $propertyName)
    {
        $actual = $obj->$propertyName;
        $this->assertEquals($expected, $actual);
    }

    /**
     * @testdox Can set properties with setters.
     * @param mixed|null $expected
     * @param mixed      $obj
     * @param string     $propertyName
     * @param mixed      $value
     *
     * @return void
     * @dataProvider setAccesiblePropertiesProvider
     */
    public function testSetAccesibleProperties($expected, $obj, $propertyName, $value = null)
    {
        $actual = null;
        if ($expected === null) {
            // Check not throws any error
            $obj->$propertyName = $value;
        } else {
            $obj->$propertyName = $value;
            $actual = $obj->$propertyName;
        }

        $this->assertEquals($expected, $actual);
    }

    /**
     * @testdox Informs when trying to access inexistent or inaccesible properties (catchable exception)
     * @expectedException BadMethodCallException
     * @dataProvider unaccesiblePropertiesProvider
     */
    public function testUnaccesibleProperties($obj, $propertyName, $value = null)
    {
        $actual = null;

        if ($value === null) {
            $tmp = $obj->$propertyName;
        } else {
            $obj->$propertyName = $value;
        }

        $this->assertNull($actual);
    }
}
