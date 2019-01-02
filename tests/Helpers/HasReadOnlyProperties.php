<?php
/**
 * PHP: Nelson Martell Library file
 *
 * Copyright © 2017-2019 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright 2017-2019 Nelson Martell
 * @link      http://nelson6e65.github.io/php_nml/
 * @since     v0.7.0
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

namespace NelsonMartell\Test\Helpers;

use Cake\Utility\Inflector;
use NelsonMartell\Extensions\Text;
use NelsonMartell\IStrictPropertiesContainer;
use SebastianBergmann\Exporter\Exporter;
use BadMethodCallException;

/**
 * Split of ImplementsIStrictPropertiesContainer, for classes implementing any write-only property.
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * */
trait HasReadOnlyProperties
{
    /**
     * ImplementsIStrictPropertiesContainer trait provides this method implementation.
     *
     * @returns IStrictPropertiesContainer
     * @see ImplementsIStrictPropertiesContainer::testImplementsIStrictPropertiesContainerInterface()
     */
    abstract public function testImplementsIStrictPropertiesContainerInterface($obj);

    abstract public function readonlyPropertiesProvider();


    /**
     * @depends testImplementsIStrictPropertiesContainerInterface
     *
     * @dataProvider readonlyPropertiesProvider
     */
    public function testReadonlyPropertiesAreReadables(
        IStrictPropertiesContainer $obj,
        $property,
        $expected
    ) {
        try {
            $actual = $obj->$property;
        } catch (BadMethodCallException $e) {
            $message = Text::format(
                'Property `{1}` it should be accessible, but does it throws an exception: "{2}".',
                get_class($obj),
                $property,
                $e->getMessage()
            );

            $this->fail($message);
        }

        $exporter = new Exporter();

        $var = get_class($obj);
        $var = Inflector::variable(substr(
            $var,
            strrpos($var, '\\') === false ? 0 : strrpos($var, '\\') + 1
        ));

        $message = Text::format(
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
     * @depends testImplementsIStrictPropertiesContainerInterface
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
}
