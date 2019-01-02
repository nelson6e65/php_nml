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

/**
 * Split of ImplementsIStrictPropertiesContainer, for classes implementing any write-only property.
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * */
trait HasWriteOnlyProperties
{
    /**
     * @returns IStrictPropertiesContainer
     */
    abstract public function testImplementsIStrictPropertiesContainerInterface($obj);

    abstract public function writeonlyPropertiesProvider();

    /**
     * @dataProvider writeonlyPropertiesProvider
     */
    public function testWriteonlyPropertiesAreWritables(
        IStrictPropertiesContainer $obj,
        $property,
        $value
    ) {
        $obj->$property = $value;
    }

    /**
     * @depends testWriteonlyPropertiesAreWritables
     * @dataProvider writeonlyPropertiesProvider
     * @expectedException \BadMethodCallException
     */
    public function testWriteonlyPropertiesAreNotReadables(
        IStrictPropertiesContainer $obj,
        $property,
        $value
    ) {
        $obj->$property = $value;
        $actual = $obj->$property;
    }
}
