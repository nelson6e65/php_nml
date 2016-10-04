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

use NelsonMartell\Test\Helpers\ExporterPlugin;
use \InvalidArgumentException;

/**
 * Data providers for NelsonMartell\Test\TestCase\PropertiesHandlerTest.
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * @internal
 * */
trait PropertiesHandlerTestProvider
{
    use ExporterPlugin;

    public function getAccesiblePropertiesProvider()
    {
        $a = new ExampleClass\A;
        $b = new ExampleClass\B;
        $c = new ExampleClass\C;
        $d = new ExampleClass\D;
        return [
            'Get property accesible via a wrapper'        => [-1, $a, 'property1'],
            'Get property accesible using attribute name' => [-2, $a, 'attribute2'],
            'Get property accesible from parent only'     => [-4, $b, 'property4'],
            'Custom prefix: Own attribute directly'       => [(-5 * 2), $c, 'attribute5'],
            'Custom prefix: Own property directly'        => [-6, $c, 'property6'],
            'Custom prefix: Own property directly2'        => [-9, $d, 'property9'],
            'Custom prefix: Parent property'              => [-1, $d, 'property1'],
            'Custom prefix: Parent property (using default prefix)' => [-3, $c, 'property3'],
        ];
    }

    /**
     * testSetAccesibleProperties
     */
    public function setAccesiblePropertiesProvider()
    {
        $a = new ExampleClass\A;
        $b = new ExampleClass\B;
        $c = new ExampleClass\C;
        $d = new ExampleClass\D;

        return [
            'Public read-write property: Set attribute with setter'            => [(3 * 100), $a, 'property3', 3],
            'Set parent attribute accesible from parent (write-only property)' => [null, $b, 'property2', 2],
            'Custom prefix: Own property'                                      => [(6 * 99), $c, 'property6', 6],
        ];
    }

    public function unaccesiblePropertiesProvider()
    {
        $a = new ExampleClass\A;
        $b = new ExampleClass\B;
        $c = new ExampleClass\C;
        $d = new ExampleClass\D;

        return [
            'Get inexistent property in base'      => [$a, 'property4'],
            'Get inexistent property in child'     => [$b, 'property5'],
            'Set inexistent property'              => [$a, 'property6', 6],
            'Set read-only property'               => [$b, 'property4', 4],
            'Set read-only attribute'              => [$a, 'attribute4', 4],
            'Set write-only property'              => [$a, 'property2', 2],
            'Set unaccesible property from parent' => [$b, 'property1', 1],
            'Existent, but wrong prefixes'         => [$b, 'property7'],
            'Existent, but wrong prefixes'         => [$b, 'property7', 7],
            'Double definition of custom getter prefix: D::C' => [$d, 'property6'],
            'Double definition of custom setter prefix: D::C' => [$d, 'property6', 6],
        ];
    }
}
