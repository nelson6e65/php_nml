<?php declare(strict_types=1);
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

use BadMethodCallException;

use NelsonMartell\Extensions\Text;

use NelsonMartell\IStrictPropertiesContainer;

use SebastianBergmann\Exporter\Exporter;

/**
 * Split of ImplementsIStrictPropertiesContainer, for classes implementing any write-only property.
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * */
trait HasReadOnlyProperties
{
    use TestCaseMethods;

    /**
     * ImplementsIStrictPropertiesContainer trait provides this method implementation.
     *
     * @see ImplementsIStrictPropertiesContainer::testImplementsIStrictPropertiesContainerInterface()
     */
    abstract public function testImplementsIStrictPropertiesContainerInterface() : void;

    abstract public function readonlyPropertiesProvider();


    /**
     * @depends testImplementsIStrictPropertiesContainerInterface
     *
     * @dataProvider readonlyPropertiesProvider
     *
     * @param IStrictPropertiesContainer $obj
     * @param string                     $property
     * @param mixed                      $expected
     */
    public function testReadonlyPropertiesAreReadables(
        IStrictPropertiesContainer $obj,
        string $property,
        $expected
    ) : void {
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
        $var = Text::variable(substr(
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
     *
     * @param IStrictPropertiesContainer|null   $obj
     * @param string|null                       $property
     * @param mixed                             $value
     */
    public function testReadonlyPropertiesAreNotWritables(
        IStrictPropertiesContainer $obj = null,
        string $property = null,
        $value = null
    ) : void {
        $obj->$property = $value;
    }
}
