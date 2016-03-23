<?php
/**
 * PHP: Nelson Martell Library file
 *
 * Content:
 * - Test case for: [NelsonMartell] Version
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
use NelsonMartell\VersionComponent;
use \PHPUnit_Framework_TestCase as TestCase;
use \InvalidArgumentException;

/**
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * @internal
 * */
class VersionComponentTest extends TestCase
{
    /**
     * @coverage VersionComponent::__construct
     * @param integer $int [description]
     * @param string $str [description]
     *
     * @return void
     * @dataProvider constructorArgumentsProvider
     */
    public function testCreatesNewInstances($int, $str)
    {
        $obj = new VersionComponent($int, $str);
        $this->assertInstanceOf(VersionComponent::class, $obj);
    }

    public function constructorArgumentsProvider()
    {
        return [
            'null values'       => [null, null],
            'Only integer part' => [1, null],
            'Only string part'  => [null, '-alpha'],
            'All arguments'     => [5, '-beta'],
            'Git describe'      => [19, '-g7575872'],
        ];
    }

    /**
     * @coverage VersionComponent::__construct
     * @expectedException InvalidArgumentException
     * @dataProvider badConstructorArgumentsProvider
     */
    public function testInformsWhenErrorOccursOnCreatingNewInstances($major, $minor, $build = null, $rev = null)
    {
        $obj = new VersionComponent($major, $minor, $build, $rev);
    }

    public function badConstructorArgumentsProvider()
    {
        return [
            'Negative integer part'        => [-1, null],
            'Invalid string value part'    => [0, 'erróneo'],
            'Invalid type (float) for string part'  => [0, 23.912],
            'Invalid type (object) for string part'  => [0, new \stdClass],
            'Invalid type (array) for string part'  => [0, ['no']],
        ];
    }

    /**
     * @coverage VersionComponent::parse
     */
    public function testPerformsConversionFromString()
    {
        $this->markTestIncomplete(
            'Tests for "'.VersionComponent::class.'::parse'.'" has not been completed yet.'
        );
    }

    /**
     * @coverage VersionComponent::__toString
     * @coverage VersionComponent::toString
     */
    public function testPerformsConversionToString()
    {
        $this->markTestIncomplete(
            'Tests for "'.VersionComponent::class.'::__toString|toString'.'" has not been completed yet.'
        );
    }

    /**
     * @coverage VersionComponent::__toString
     * @coverage VersionComponent::toString
     */
    public function testPerformsImplicitConversionToString()
    {
        $this->markTestIncomplete(
            'Tests for "'.VersionComponent::class.'::__toString'.'" has not been completed yet.'
        );
    }

    /**
     * @coverage VersionComponent::isNull
     * @coverage VersionComponent::isNotNull
     * @coverage VersionComponent::isDefault
     * @coverage VersionComponent::isNotDefault
     */
    public function testCanCheckIfVersionComponentIsInDefaultOrNullState()
    {
        $this->markTestIncomplete(
            'Tests for "'.VersionComponent::class.'::isNull|isNotNull|isDefault|isNotDefault'.
            '" has not been completed yet.'
        );
    }
}
