<?php
/**
 * PHP: Nelson Martell Library file
 *
 * Content:
 * - Trait definition
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

namespace NelsonMartell\Test\Helpers;

use Cake\Utility\Inflector;
use NelsonMartell\Extensions\String;
use NelsonMartell\IStrictPropertiesContainer;
use SebastianBergmann\Exporter\Exporter;

/**
 * Test helper for classes implementing ``NelsonMartell\IStrictPropertiesContainer`` interface and
 * ``NelsonMartell\PropertiesHandler`` trait.
 *
 * You can pass an empty in some providers to skip test. For example, if a class has not 'write-only' properties)
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * */
trait IStrictPropertiesContainerTester
{
    public abstract function readonlyPropertiesProvider();
    public abstract function writeonlyPropertiesProvider();
    public abstract function readwritePropertiesProvider();
    public abstract function unaccesiblePropertiesProvider();
    public abstract function objectInstanceProvider();

    /**
     * Optional if provider returns an empty array.
     *
     * @dataProvider readonlyPropertiesProvider
     */
    public function testReadonlyPropertiesAreReadables(
        IStrictPropertiesContainer $obj = null,
        $property = null,
        $expected = null
    ) {
        if ($obj === null) {
            $this->markTestSkipped('Target class has not read-only properties.');
        }

        $exporter = new Exporter();

        $var = get_class($obj);
        $var = Inflector::variable(substr(
            $var,
            strrpos($var, '\\') === false ? 0 : strrpos($var, '\\') + 1
        ));

        $actual = $obj->$property;

        $message = String::format(
            '$actual = ${var}->{property}; // {actual}',
            [
                'var'      => $var,
                'property' => $property,
                'actual'   => $exporter->shortenedExport($actual)
            ]
        );

        $this->assertEquals($expected, $actual, $message);
    }

    /**
     * @depends testReadonlyPropertiesAreReadables
     * @dataProvider readonlyPropertiesProvider
     * @expectedException \BadMethodCallException
     */
    public function testReadonlyPropertiesAreNotWritables(
        IStrictPropertiesContainer $obj = null,
        $property = null,
        $value = null
    ) {
        $obj->$property = $value;
    }

    /**
     * @dataProvider writeonlyPropertiesProvider
     */
    public function testWriteonlyPropertiesAreWritables(
        IStrictPropertiesContainer $obj = null,
        $property = null,
        $value = null
    ) {
        if ($obj === null) {
            $this->markTestSkipped('Target class has not write-only properties to test.');
        }

        $obj->$property = $value;
    }

    /**
     * @depends testWriteonlyPropertiesAreWritables
     * @dataProvider writeonlyPropertiesProvider
     * @expectedException \BadMethodCallException
     */
    public function testWriteonlyPropertiesAreNotReadables(
        IStrictPropertiesContainer $obj = null,
        $property = null,
        $value = null
    ) {
        $obj->$property = $value;
        $actual = $obj->$property;
    }

    /**
     * @dataProvider readwritePropertiesProvider
     */
    public function testPropertiesWithFullAccessAreReadablesAndWritables(
        IStrictPropertiesContainer $obj = null,
        $property = null,
        $value = null,
        $expected = null
    ) {
        if ($obj === null) {
            $this->markTestSkipped('Target class has not read-write properties to test.');
        }

        $exporter = new Exporter();

        $var = get_class($obj);
        $var = Inflector::variable(substr(
            $var,
            strrpos($var, '\\') === false ? 0 : strrpos($var, '\\') + 1
        ));

        $obj->$property = $value;

        $actual = $obj->$property;

        $message = String::format(
            '${var}->{property} = {value}; $actual = ${var}->{property}; // {actual}',
            [
                'var'      => $var,
                'property' => $property,
                'actual'   => $exporter->shortenedExport($actual),
                'value'    => $exporter->shortenedExport($value),
            ]
        );

        $this->assertEquals($expected, $actual, $message);
    }

    /**
     * @dataProvider unaccesiblePropertiesProvider
     * @expectedException \BadMethodCallException
     */
    public function testUnaccessiblePropertiesThrowsCatchableError(
        IStrictPropertiesContainer $obj = null,
        $property = null,
        $value = null
    ) {
        if ($obj === null) {
            $this->markTestSkipped('Target class has not unaccesible properties to test.');
        }

        if ($value === null) {
            // Getter exception
            $actual = $obj->$property;
        } else {
            // Setter exception
            $obj->$property = $value;
        }
    }

    /**
     * @dataProvider objectInstanceProvider
     * @expectedException \BadMethodCallException
     */
    public function testIsUnableToCreateDirectAttributesOutsideOfClassDefinition(IStrictPropertiesContainer $obj)
    {
        $obj->thisPropertyNameIsMaybeImposibleThatExistsInClassToBeUsedAsNameOfPropertyOfAnyClassGiven = 'No way';
    }
}
