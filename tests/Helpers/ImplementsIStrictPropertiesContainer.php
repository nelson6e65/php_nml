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
 * @since     v0.6.0, v0.7.0
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

namespace NelsonMartell\Test\Helpers;

use ReflectionClass;

use NelsonMartell\Extensions\Text;

use NelsonMartell\IStrictPropertiesContainer;

use PHPUnit\Framework\TestCase;

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

    /**
     * @return string
     */
    abstract public function getTargetClassName() : string;

    abstract public function objectInstanceProvider();

    /**
     *
     */
    public function testImplementsIStrictPropertiesContainerInterface() : void
    {
        /** @var TestCase $this */
        $class = new ReflectionClass($this->getTargetClassName());

        if ($class->isTrait()) {
            $this->assertTrue(true);
            return;
        }

        $message = Text::format(
            '"{0}" do not implements "{1}" interface.',
            $this->getTargetClassName(),
            IStrictPropertiesContainer::class
        );

        $this->assertContains(
            IStrictPropertiesContainer::class,
            $class->getInterfaceNames(),
            $message
        );
    }

    /**
     * @depends testImplementsIStrictPropertiesContainerInterface
     * @dataProvider objectInstanceProvider
     * @expectedException \BadMethodCallException
     *
     * @param IStrictPropertiesContainer $obj
     */
    public function testIsUnableToCreateDirectAttributesOutsideOfClassDefinition(IStrictPropertiesContainer $obj)
    {
        $obj->thisPropertyNameIsMaybeImposibleThatExistsInClassToBeUsedAsNameOfPropertyOfAnyClassGiven = 'No way';
    }
}
