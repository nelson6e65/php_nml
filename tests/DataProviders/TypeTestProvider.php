<?php
/**
 * PHP: Nelson Martell Library file
 *
 * Content:
 * - Trait definition.
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

namespace NelsonMartell\Test\DataProviders;

use NelsonMartell\Type;
use NelsonMartell\Test\Helpers\ConstructorMethodTester;
use NelsonMartell\Test\Helpers\IStrictPropertiesContainerTester;
use NelsonMartell\Test\DataProviders\ExampleClass\ToString;

/**
 * Data providers for NelsonMartell\Test\TestCase\TypeTest.
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * @internal
 * */
trait TypeTestProvider
{
    use ConstructorMethodTester;
    use IStrictPropertiesContainerTester;

    /**
     * Provides valid arguments for constructor.
     *
     * @return array
     */
    public function goodConstructorArgumentsProvider()
    {
        return [
            'NULL'        => [null, true],
            'integer'     => [1, true],
            'double'      => [1.9999, true],
            'string'      => ['str', true],
            ToString::class => [new ToString(), true],
            'array'       => [[], false],
            'stdClass'    => [new \stdClass, false],
            __CLASS__     => [$this, false],
        ];
    }

    public function toStringCheckProvider()
    {
        return [
            'NULL'          => ['NULL', null],
            'integer'       => ['integer', 1],
            'double'        => ['double', 1.9999],
            'string'        => ['string', 'str'],
            'array'         => ['array', []],
            'stdClass'      => ['object (stdClass)', new \stdClass],
            __CLASS__       => ['object (NelsonMartell\Test\TestCase\TypeTest)', $this],
        ];
    }

    /**
     * This class constructor do not throws argument exceptions, so, using any type should be pass.
     * @return array
     */
    public function badConstructorArgumentsProvider()
    {
        return $this->goodConstructorArgumentsProvider();
    }

    #GROUP: IStrictPropertiesContainerTester

    /**
     * @return array
     */
    public function readonlyPropertiesProvider()
    {
        $obj = new Type($this);

        return [
            [$obj, 'name', __CLASS__],
            [$obj, 'ShortName', 'TypeTest'],
            [$obj, 'Namespace', 'NelsonMartell\Test\TestCase', ],
        ];
    }

    public function writeonlyPropertiesProvider()
    {
        return null;
    }

    public function readwritePropertiesProvider()
    {
        return null;
    }

    public function unaccesiblePropertiesProvider()
    {
        return null;
    }

    public function objectInstanceProvider()
    {
        return [[new Type($this)]];
    }

    #ENDGROUP
}
