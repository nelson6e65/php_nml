<?php
/**
 * PHP: Nelson Martell Library file
 *
 * Content:
 * - Trait definition
 *
 * Copyright © 2016-2017 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright 2016-2017 Nelson Martell
 * @link      http://nelson6e65.github.io/php_nml/
 * @since     v0.6.0, v0.7.0
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

namespace NelsonMartell\Test\Helpers;

use Cake\Utility\Inflector;
use NelsonMartell\Extensions\Text;
use NelsonMartell\IStrictPropertiesContainer;
use SebastianBergmann\Exporter\Exporter;

/**
 * Test helper for classes implementing ``NelsonMartell\IStrictPropertiesContainer`` interface and
 * ``NelsonMartell\PropertiesHandler`` trait.
 *
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 *
 * @see HasReadOnlyProperties
 * @see HasReadWriteProperties
 * @see HasUnaccesibleProperties
 * @see HasWriteOnlyProperties
 * */
trait ImplementsIStrictPropertiesContainer
{
    public abstract function objectInstanceProvider();

    /**
     * @dataProvider objectInstanceProvider
     * @todo Check returning value of dependency tests.
     */
    public function testImplementsIStrictPropertiesContainerInterface($obj)
    {
        $this->assertInstanceOf(IStrictPropertiesContainer::class, $obj);

        return $obj;
    }

    /**
     * @depends testImplementsIStrictPropertiesContainerInterface
     * @dataProvider objectInstanceProvider
     * @expectedException \BadMethodCallException
     */
    public function testIsUnableToCreateDirectAttributesOutsideOfClassDefinition(IStrictPropertiesContainer $obj)
    {
        $obj->thisPropertyNameIsMaybeImposibleThatExistsInClassToBeUsedAsNameOfPropertyOfAnyClassGiven = 'No way';
    }
}
