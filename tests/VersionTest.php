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
use NelsonMartell\Version;
use NelsonMartell\VersionComponent;
use NelsonMartell\Object;
use NelsonMartell\Extensions\String;
use NelsonMartell\Test\plugins\ExporterPlugin;
use \PHPUnit_Framework_TestCase as TestCase;
use \InvalidArgumentException;

/**
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * @internal
 * */
class VersionTest extends TestCase
{
    use VersionTestProvider;
    use TestConstructorHelper;
    use IComparableTestHelper;
    use ExporterPlugin;

    public function getTargetClassName()
    {
        return Version::class;
    }

    /**
     * @coverage Version::parse
     * @depends NelsonMartell\Test\VersionComponentTest::testPerformsConversionFromString
     */
    public function testPerformsConversionFromString()
    {
        // Test for array ['invalid', 'array']
        $this->markTestIncomplete(
            'Tests for "'.Version::class.'::parse'.'" has not been completed yet.'
        );
    }

    /**
     * @coverage Version::parse
     * @depends testCreatesNewInstances
     * @depends NelsonMartell\Test\VersionComponentTest::testPerformsConversionToString
     */
    public function testPerformsConversionToString()
    {
        $obj = new Version(0, 6, 0);
        $this->assertEquals('0.6.0', $obj->toString());

        $this->markTestIncomplete(
            'Tests for "'.Version::class.'::toString|__toString'.'" has not been completed yet.'
        );
    }

    /**
     * @coverage Version::__toString
     * @coverage Version::toString
     * @depends testPerformsConversionToString
     * @depends NelsonMartell\Test\VersionComponentTest::testPerformsImplicitConversionToString
     */
    public function testPerformsImplicitConversionToString()
    {
        $obj = new Version(0, 6, 0);
        $this->assertEquals('v0.6.0', 'v'.$obj);

        $obj = new Version(0, 6, 0, 0);
        $this->assertEquals('v0.6.0.0', 'v'.$obj);

        $this->markTestIncomplete(
            'Tests for "'.Version::class.'::__toString'.'" has not been completed yet.'
        );
    }

    /**
     * @coverage Version::isValid
     * @depends testCreatesNewInstances
     */
    public function testCanCheckIfVersionIsValid()
    {
        $obj = new Version(0, 0, 0, 0);
        $this->assertFalse($obj->isValid());

        $obj = new Version(0, 2, 0, 0);
        $this->assertTrue($obj->isValid());

        $this->markTestIncomplete(
            'Tests for "'.Version::class.'::isValid'.'" has not been completed yet.'
        );
    }
}
