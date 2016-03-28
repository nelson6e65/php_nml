<?php
/**
 * PHP: Nelson Martell Library file
 *
 * Content:
 * - Test case for: NelsonMartell\Type
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

namespace NelsonMartell\Test;

use NelsonMartell as NML;
use NelsonMartell\Type;
use NelsonMartell\Extensions\String;
use NelsonMartell\Test\plugins\ExporterPlugin;
use \PHPUnit_Framework_TestCase as TestCase;
use \InvalidArgumentException;

/**
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * @internal
 * */
class TypeTest extends TestCase
{
    use TypeTestProvider;
    use TestConstructorHelper;
    use ExporterPlugin;

    public function getTargetClassName()
    {
        return Type::class;
    }

    /**
     * @testdox Informs when error occurs on creating new instances
     * @dataprovider badConstructorArgumentsProvider
     */
    public function testConstructorWithBadArguments()
    {
        $this->markTestSkipped(String::format(
            '"{0}" class do not throws intentional exceptions in constructor.',
            Type::class
        ));
    }

    /**
     * @coverage Type::toString
     * @coverage Type::__toString
     * @dataProvider toStringCheckProvider
     */
    public function testPerformsConversionToString($expected, $arg)
    {
        $obj    = new Type($arg);
        $actual = $obj->toString();

        $this->assertInternalType('string', $actual);
        $this->assertEquals($expected, $actual);

        $actual   = "Implicit converted: $actual";
        $expected = "Implicit converted: $expected";
        $this->assertEquals($expected, $actual);

    }

    /**
     * @coverage Type::getName
     */
    public function testCanGetNameOfType()
    {
        $this->markTestIncomplete(
            'Tests for "'.Type::class.'::getName'.'" has not been completed yet.'
        );
    }

    /**
     * @coverage Type::getShortName
     */
    public function testCanGetShortNameOfType()
    {
        $this->markTestIncomplete(
            'Tests for "'.Type::class.'::getShortName'.'" has not been completed yet.'
        );
    }

    /**
     * @coverage Type::getNamespace
     */
    public function testCanGetNamespaceOfType()
    {
        $this->markTestIncomplete(
            'Tests for "'.Type::class.'::getNamespace'.'" has not been completed yet.'
        );
    }

    /**
     * @coverage Type::hasMethod
     */
    public function testCanCheckIfAClassHasAMethod()
    {
        $this->markTestIncomplete(
            'Tests for "'.Type::class.'::hasMethod'.'" has not been completed yet.'
        );
    }

    /**
     * @coverage Type::isNUll
     * @coverage Type::isNotNUll
     */
    public function testCanCheckIfTypeIsNull()
    {
        $this->markTestIncomplete(
            'Tests for "'.Type::class.'::isNUll|isNotNUll'.'" has not been completed yet.'
        );
    }

    /**
     * @coverage Type::isCustom
     */
    public function testCanCheckIfTypeIsCustom()
    {
        $this->markTestIncomplete(
            'Tests for "'.Type::class.'::isCustom'.'" has not been completed yet.'
        );
    }

    /**
     * @coverage Type::canBeString
     */
    public function testCanCheckIfTypeCanBeConvertedToString()
    {
        $this->markTestIncomplete(
            'Tests for "'.Type::class.'::canBeString'.'" has not been completed yet.'
        );
    }
}
