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
 * @since     v0.7.0
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

namespace NelsonMartell\Test\Helpers;

use Cake\Utility\Inflector;
use NelsonMartell\Extensions\Text;
use NelsonMartell\IStrictPropertiesContainer;
use SebastianBergmann\Exporter\Exporter;

/**
 * Split of ImplementsIStrictPropertiesContainer, for classes implementing any read-only property
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * */
trait HasReadWriteProperties
{
    /**
     * @returns IStrictPropertiesContainer
     */
    public abstract function testImplementsIStrictPropertiesContainerInterface($obj);

    public abstract function readwritePropertiesProvider();


    /**
     * @depends testImplementsIStrictPropertiesContainerInterface
     * @dataProvider readwritePropertiesProvider
     */
    public function testPropertiesWithFullAccessAreReadablesAndWritables(
        IStrictPropertiesContainer $obj,
        $property,
        $value,
        $expected
    ) {
        $exporter = new Exporter();

        $var = get_class($obj);
        $var = Inflector::variable(substr(
            $var,
            strrpos($var, '\\') === false ? 0 : strrpos($var, '\\') + 1
        ));

        $obj->$property = $value;

        $actual = $obj->$property;

        $message = Text::format(
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
}
