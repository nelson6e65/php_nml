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

namespace NelsonMartell\Test\DataProviders;

use NelsonMartell\Test\Helpers\ExporterPlugin;
use NelsonMartell\Test\Helpers\HasReadOnlyProperties;
use NelsonMartell\Test\Helpers\HasReadWriteProperties;
use NelsonMartell\Test\Helpers\HasWriteOnlyProperties;
use NelsonMartell\Test\Helpers\HasUnaccesibleProperties;
use NelsonMartell\Test\Helpers\ImplementsIStrictPropertiesContainer;

use NelsonMartell\PropertiesHandler;

/**
 * Data providers for NelsonMartell\Test\TestCase\PropertiesHandlerTest.
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * @internal
 * */
trait PropertiesHandlerTestProvider
{
    use ExporterPlugin;
    use ImplementsIStrictPropertiesContainer;
    use HasUnaccesibleProperties;
    use HasWriteOnlyProperties;
    use HasReadWriteProperties;
    use HasReadOnlyProperties;

    public function getTargetClassName() : string
    {
        return PropertiesHandler::class;
    }

    public function objectInstanceProvider()
    {
        $a = new ExampleClass\A;
        $b = new ExampleClass\B;
        $c = new ExampleClass\C;
        $d = new ExampleClass\D;

        return [
            [$a],
            [$b],
            [$c],
            [$d],
        ];
    }


    public function writeonlyPropertiesProvider()
    {
        $a = new ExampleClass\A;
        $b = new ExampleClass\B;
        $c = new ExampleClass\C;
        $d = new ExampleClass\D;

        return [
            'Set parent attribute accesible from parent (write-only property)' => [$b, 'property2', 2],
        ];
    }

    public function readwritePropertiesProvider()
    {
        $a = new ExampleClass\A;
        $c = new ExampleClass\C;
        $d = new ExampleClass\D;

        $mb = new ExampleClass\WithMagicPropertiesBaseClass;
        $mc = new ExampleClass\WithMagicPropertiesChildClass;

        return [
            'Set attribute with setter'                                     => [$a, 'property3', 3, (3 * 100)],
            'Custom prefix (parent using default): Own property directly'   => [$c, 'property6', 6, (6 * 99)],
            'Custom prefix (parent using custom): Own property directly'    => [$d, 'property9', -9, -(9 * 10)],
            'Custom prefix (parent using default)): Parent property '       => [$c, 'property3', -3, -(3 * 100)],

            // Magic examples
            'Using IMagicPropertiesContainer'                               => [$mb, 'baseProperty', 'base', 'base'],
            'Parent using IMagicPropertiesContainer: Parent property'       => [$mc, 'baseProperty', 'base', 'base'],
            'Parent using IMagicPropertiesContainer: Child property'        => [$mc, 'childProperty', 'child', 'child'],
        ];
    }


    public function readonlyPropertiesProvider()
    {
        $a = new ExampleClass\A;
        $b = new ExampleClass\B;
        $c = new ExampleClass\C;
        $d = new ExampleClass\D;

        $mc = new ExampleClass\WithMagicPropertiesChildClass;

        return [
            'Get property accesible via a wrapper'                  => [$a, 'property1', -1],
            'Get property accesible using attribute name'           => [$a, 'attribute2', -2],
            'Get property accesible from parent only'               => [$b, 'property4', -4],
            'Custom prefix: Own attribute directly'                 => [$c, 'attribute5', (-5 * 2)],
            'Custom prefix: Parent property'                        => [$d, 'property1', -1],

            // Magic
            'Parent using IMagicPropertiesContainer'                => [$mc, 'readOnlyChildProperty', 1],
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
            'Get existent property with case changed' => [$a, 'Property1'],
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
