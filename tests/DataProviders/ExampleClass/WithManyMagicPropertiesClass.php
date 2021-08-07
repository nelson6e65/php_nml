<?php

/**
 * PHP: Nelson Martell Library file
 *
 * Copyright © 2021 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright 2021 Nelson Martell
 * @link      http://nelson6e65.github.io/php_nml/
 * @since     v1.0.0
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

declare(strict_types=1);

namespace NelsonMartell\Test\DataProviders\ExampleClass;

use NelsonMartell\StrictObject;
use NelsonMartell\PropertiesHandler;
use NelsonMartell\IMagicPropertiesContainer;
use NelsonMartell\IStrictPropertiesContainer;
use stdClass as VeryLongClassName;

/**
 * @internal
 *
 * @property string $UpperCaseProperty
 * @property-read string $UpperCaseWithDifferentSetterProperty
 * @property-write string|int $UpperCaseWithDifferentSetterProperty
 * @property-read VeryLongClassName|null $propertyWithLongClass  Officia deserunt mollit anim id est laborum.
 * @property-write VeryLongClassName|int|null $propertyWithLongClass Lorem ipsum dolor sit amet.
 * @property-read VeryLongClassName|null  $anotherPropertyAfterPropertyWithLongClass
 * @property-write VeryLongClassName|int|string|null $anotherPropertyAfterPropertyWithLongClass
 */
class WithManyMagicPropertiesClass implements IStrictPropertiesContainer, IMagicPropertiesContainer
{
    use PropertiesHandler;

    /**
     * @var array
     */
    private $data = [];

    public function __construct()
    {
    }


    /**
     *
     *
     * @return string
     */
    protected function getUpperCaseProperty(): string
    {
        return $this->data['UpperCaseProperty'] ?? '';
    }

    /**
     *
     * @param string|int $value
     */
    protected function setUpperCaseProperty($value)
    {
        $this->data['UpperCaseProperty'] = "${value}";
    }

    /**
     *
     *
     * @return string
     */
    protected function getUpperCaseWithDifferentSetterProperty(): string
    {
        return $this->data['UpperCaseWithDifferentSetterProperty'] ?? '';
    }

    /**
     *
     * @param string|int $value
     */
    protected function setUpperCaseWithDifferentSetterProperty($value)
    {
        $this->data['UpperCaseWithDifferentSetterProperty'] = "${value}";
    }

    /**
     * @return VeryLongClassName|null
     */
    protected function getPropertyWithLongClass()
    {
        return $this->data['propertyWithLongClass'] ?? null;
    }

    /**
     * @param VeryLongClassName|int|null $value
     */
    protected function setPropertyWithLongClass($value)
    {
        if ($value !== null && !($value instanceof VeryLongClassName)) {
            $original        = $value;
            $value           = new VeryLongClassName();
            $value->original = $original;
        }

        $this->data['propertyWithLongClass'] = $value;
    }


    /**
     * @return VeryLongClassName|null
     */
    protected function getAnotherPropertyAfterPropertyWithLongClass()
    {
        return $this->data['anotherPropertyAfterPropertyWithLongClass'] ?? null;
    }

    /**
     * @param VeryLongClassName|int|string|null $value
     */
    protected function setAnotherPropertyAfterPropertyWithLongClass($value)
    {
        if ($value !== null && !($value instanceof VeryLongClassName)) {
            $original        = $value;
            $value           = new VeryLongClassName();
            $value->original = $original;
        }

        $this->data['anotherPropertyAfterPropertyWithLongClass'] = $value;
    }
}
