<?php
/**
 * PHP: Nelson Martell Library file
 *
 * Content:
 * - Trait definition
 *
 * Copyright © 2016-2019 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright 2016-2019 Nelson Martell
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
trait HasUnaccesibleProperties
{
    /**
     * @returns IStrictPropertiesContainer
     */
    abstract public function testImplementsIStrictPropertiesContainerInterface($obj);

    abstract public function unaccesiblePropertiesProvider();

    /**
     * @dataProvider unaccesiblePropertiesProvider
     * @expectedException \BadMethodCallException
     */
    public function testUnaccessiblePropertiesThrowsCatchableError(
        IStrictPropertiesContainer $obj,
        $property,
        $value = null
    ) {

        if ($value === null) {
            // Getter exception
            $actual = $obj->$property;
        } else {
            // Setter exception
            $obj->$property = $value;
        }
    }
}
