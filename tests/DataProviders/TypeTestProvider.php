<?php declare(strict_types=1);
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
 * @since     0.6.0
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

namespace NelsonMartell\Test\DataProviders;

use NelsonMartell\IConvertibleToString;
use NelsonMartell\ICustomPrefixedPropertiesContainer;
use NelsonMartell\IStrictPropertiesContainer;
use NelsonMartell\PropertiesHandler;
use NelsonMartell\Type;

use NelsonMartell\Test\DataProviders\ExampleClass\A;
use NelsonMartell\Test\DataProviders\ExampleClass\B;
use NelsonMartell\Test\DataProviders\ExampleClass\C;
use NelsonMartell\Test\DataProviders\ExampleClass\ToString;
use NelsonMartell\Test\DataProviders\ExampleClass\WithSomeMethodsChildClass;
use NelsonMartell\Test\DataProviders\ExampleClass\WithSomeMethodsClass;

use NelsonMartell\Test\Helpers\ConstructorMethodTester;
use NelsonMartell\Test\Helpers\HasReadOnlyProperties;
use NelsonMartell\Test\Helpers\HasUnaccesibleProperties;
use NelsonMartell\Test\Helpers\ImplementsIConvertibleToString;
use NelsonMartell\Test\Helpers\ImplementsIStrictPropertiesContainer;
use NelsonMartell\Test\Helpers\TestCaseMethods;

use NelsonMartell\Test\TestCase\TypeTest;

use InvalidArgumentException;
use stdClass;

use function NelsonMartell\typeof;

/**
 * Data providers for NelsonMartell\Test\TestCase\TypeTest.
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * @since  0.6.0
 * @internal
 * */
trait TypeTestProvider
{
    use ConstructorMethodTester;
    use HasReadOnlyProperties;
    use HasUnaccesibleProperties;
    use ImplementsIConvertibleToString;
    use ImplementsIStrictPropertiesContainer;

    /**
     *
     * @return array
     * @since 1.0.0-dev
     */
    public function unaccesiblePropertiesProvider() : array
    {
        $obj = new Type($this);

        return [
            '$reflectionObject'             => [$obj, 'reflectionObject'],
            '$namespace with case changed'  => [$obj, 'Namespace'],
            '$name with case changed'       => [$obj, 'Name'],
            '$shortName with case changed'  => [$obj, 'ShortName'],
            '$methods with case changed'    => [$obj, 'Methods'],
            '$vars with case changed'       => [$obj, 'Vars'],
        ];
    }

    /**
     * Provides valid arguments for constructor.
     *
     * @return array
     */
    public function goodConstructorArgumentsProvider() : array
    {
        return [
            'NULL'        => [null],
            'integer'     => [1],
            'double'      => [1.9999],
            'string'      => ['str'],
            ToString::class => [new ToString()],
            'array'       => [[]],
            'stdClass'    => [new \stdClass],
            __CLASS__     => [$this],

            'string: '.ToString::class => [ToString::class, true],
            'string: '.stdClass::class => [stdClass::class, true],
            'non string as `$obj` arg' => [new stdClass, true],
        ];
    }

    public function toStringProvider() : array
    {
        return [
            'NULL'          => ['NULL', typeof(null)],
            'integer'       => ['integer', typeof(1)],
            'double'        => ['double', typeof(1.9999)],
            'string'        => ['string', typeof('str')],
            'array'         => ['array', typeof([])],
            'stdClass'      => ['object (stdClass)', typeof(new \stdClass)],
            __CLASS__       => ['object (NelsonMartell\Test\TestCase\TypeTest)', typeof($this)],
        ];
    }

    public function badConstructorArgumentsProvider() : array
    {
        return [
            'not existing class'   => [InvalidArgumentException::class, 'Hola', true],
        ];
    }

    public function canBeStringProvider() : array
    {
        return [
            'NULL'        => [null],
            'integer'     => [1],
            'double'      => [1.9999],
            'string'      => ['str'],
            ToString::class => [new ToString()],
            'string: '.ToString::class => [ToString::class, true],
        ];
    }

    public function canNotBeStringProvider() : array
    {
        return [
            'array'       => [[]],
            'stdClass'    => [new \stdClass],
            __CLASS__     => [$this],
            'string: '.stdClass::class => [stdClass::class, true],
        ];
    }


    /**
     * @return array
     */
    public function readonlyPropertiesProvider() : array
    {
        $obj = new Type($this);

        return [
            [$obj, 'name', __CLASS__],
            [$obj, 'shortName', 'TypeTest'],
            [$obj, 'namespace', 'NelsonMartell\Test\TestCase'],
        ];
    }

    public function objectInstanceProvider() : array
    {
        return [[new Type($this)]];
    }

    /**
     * [
     *  (bool) if should match,
     *  (mixed) type,
     *  (array) objects
     * ]
     * @return array
     */
    public function methodIsProvider() : array
    {
        return [
            [true,  (bool) true,    [true, false]],
            [false, (bool) false,   [true, false, 0]],
            [true,  (int) 123,      [11, 0, -34]],
            [false, (int) 123,      [11, 0, -34.456]],
            [true,  (float) 1.23,   [11.0, 0.0, -34.6]],
            [false, (float) 1.23,   [11.0, 0, -34.4]],
            [true,  (string) '',    ['', '0', 'i am not a string']],
            [false, (string) '',    [11.2, '0', true]],
            [true,  null,           [null, null]],
            [false, null,           [[], null, false]],
            [true,  new stdClass,   [new stdClass, new stdClass]],
            [false, new stdClass,   [[], new stdClass, true]],
        ];
    }

    /**
     * [
     *  (bool) if should match,
     *  (mixed) type,
     *  (array) objects
     * ]
     * @return array
     */
    public function methodIsInProvider() : array
    {
        return [
            [true,  (bool) true,    [true, false, 1, 'string']],
            [false, (bool) false,   ['true', 'false', 0, 1]],
            [true,  (int) 123,      [11, 0, -34]],
            [false, (int) 123,      [11.2, '0', true]],
            [true,  (float) 1.23,   [11, 0.5, -34]],
            [false, (float) 1.23,   [11, '0', true]],
            [true,  (string) '',    [11, '0', -34]],
            [false, (string) '',    [11.2, 0, true]],
            [true,  null,           [null, true, 4]],
            [false, null,           [[], 'null', false]],
            [true,  new stdClass,   [new stdClass, new A, 0]],
            [false, new stdClass,   [[], 'stdClass', true]],
        ];
    }

    /**
     * [
     *      (mixed) object,
     *      (array<string>) interfaces
     * ]
     *
     * @return array
     */
    public function getInterfacesProvider() : array
    {
        return [
            [new A, [IStrictPropertiesContainer::class]],
            [new B, [IStrictPropertiesContainer::class]],
            [new C, [ICustomPrefixedPropertiesContainer::class, IStrictPropertiesContainer::class]],
            [new ToString, [IConvertibleToString::class]],
            ['string', []],
        ];
    }

    /**
     * [
     *      (mixed) object,
     *      (array<string>) interfaces
     * ]
     *
     * @return array
     */
    public function getTraitsProvider() : array
    {
        return [
            [new A, [PropertiesHandler::class]],
            [new B, []],
            [new C, []],
            [new ToString, []],
            [new Type(TypeTest::class, true), [
                TypeTestProvider::class,
            ]],
            ['string', []],
        ];
    }

    /**
     * [
     *      (mixed) object,
     *      (array<string>) interfaces
     * ]
     *
     * @return array
     */
    public function getRecursiveTraitsProvider() : array
    {
        return [
            [new A, [PropertiesHandler::class]],
            [new B, [PropertiesHandler::class]],
            [new C, [PropertiesHandler::class]],
            [new Type(TypeTest::class, true), [
                ConstructorMethodTester::class,
                HasReadOnlyProperties::class,
                HasUnaccesibleProperties::class,
                ImplementsIConvertibleToString::class,
                ImplementsIStrictPropertiesContainer::class,
                TestCaseMethods::class,
                TypeTestProvider::class,
            ]],
            [new ToString, []],
            ['string', []],
        ];
    }

    /**
     * <mixed, string>
     *
     * @return array
     */
    public function hasPropertyProvider() : array
    {
        return [
            [new A, 'attribute1'],
            [new A, 'property1'],
            [new Type(A::class, true), 'attribute4'],
            [new B, 'property2'],
            [new B, 'attribute2'],
        ];
    }

    /**
     * <mixed, string>
     *
     * @return array
     */
    public function hasNotPropertyProvider() : array
    {
        $obj = new stdClass;

        $obj->testProperty = 0;

        return [
            ['string', ''],
            [new A, 'xyz'],
            [new A, 'Property1'],
            [new B, 'property5'],
            'should ignore dinamic properties' => [$obj, 'testProperty'],
        ];
    }

    /**
     *
     *
     * @return array[] mixed => string
     */
    public function hasMethodProvider() : array
    {
        $obj = new WithSomeMethodsClass;
        $obk = new WithSomeMethodsChildClass;

        return [
            'private' => [$obj, 'privateMethod'],
            'protected' => [$obj, 'protectedMethod'],
            'public' => [$obj, 'publicMethod'],
            // 'magic' => [$obj, 'magicMethod'], // FIXME Implement detection of magic methods

            'private in parent' => [$obk, 'privateMethod'],
            'protected in parent' => [$obk, 'protectedMethod'],
            'public in parent' => [$obk, 'publicMethod'],
            // 'magic in parent' => [$obk, 'magicMethod'], // FIXME Implement detection of magic methods
        ];
    }

    public function hasNotMethodProvider() : array
    {
        $obj = new WithSomeMethodsClass;

        return [
            [$obj, 'someMethodThatIsNotDefined']
        ];
    }
}
