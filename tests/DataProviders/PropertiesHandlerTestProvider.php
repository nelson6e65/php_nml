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

namespace NelsonMartell\Test\DataProviders;

use NelsonMartell as NML;
use NelsonMartell\Object;
use NelsonMartell\Extensions\String;
use NelsonMartell\Test\Helpers\ExporterPlugin;
use NelsonMartell\Test\DataProviders\ExampleClass\A;
use NelsonMartell\Test\DataProviders\ExampleClass\B;
use NelsonMartell\Test\DataProviders\ExampleClass\C;
use NelsonMartell\Test\DataProviders\ExampleClass\D;
use \InvalidArgumentException;

/**
 * Data providers for NelsonMartell\Test\TestCase\PropertiesHandlerTest.
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * @internal
 * */
trait PropertiesHandlerTestProvider
{
    public function getAccesiblePropertiesProvider()
    {
        return [
            'Get property accesible via a wrapper'        => [-1, new A(), 'property1'],
            'Get property accesible using attribute name' => [-2, new A(), 'attribute2'],
            'Get property accesible from parent only'     => [-4, new B(), 'property4'],
            'Custom prefix: Own attribute directly'       => [(-5 * 2), new C, 'attribute5'],
            'Custom prefix: Own property directly'        => [-6, new C, 'property6'],
            'Custom prefix: Own property directly2'        => [-9, new D, 'property9'],
            'Custom prefix: Parent property'              => [-1, new D, 'property1'],
            'Custom prefix: Parent property (using default prefix)' => [-3, new C, 'property3'],
        ];
    }

    /**
     * testSetAccesibleProperties
     */
    public function setAccesiblePropertiesProvider()
    {
        return [
            'Public read-write property: Set attribute with setter'            => [(3 * 100), new A, 'property3', 3],
            'Set parent attribute accesible from parent (write-only property)' => [null, new B, 'property2', 2],
            'Custom prefix: Own property'                                      => [(6 * 99), new C, 'property6', 6],
        ];
    }

    public function unaccesiblePropertiesProvider()
    {
        return [
            'Get inexistent property in base'      => [new A(), 'property4'],
            'Get inexistent property in child'     => [new B(), 'property5'],
            'Set inexistent property'              => [new A(), 'property6', 6],
            'Set read-only property'               => [new B(), 'property4', 4],
            'Set read-only attribute'              => [new A(), 'attribute4', 4],
            'Set write-only property'              => [new A(), 'property2', 2],
            'Set unaccesible property from parent' => [new B(), 'property1', 1],
            'Existent, but wrong prefixes'         => [new B(), 'property7'],
            'Existent, but wrong prefixes'         => [new B(), 'property7', 7],
            'Double definition of custom getter prefix: D::C' => [new D, 'property6'],
            'Double definition of custom setter prefix: D::C' => [new D, 'property6', 6],
        ];
    }
}
