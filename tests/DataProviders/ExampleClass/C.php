<?php
/**
 * PHP: Nelson Martell Library file
 *
 * Content:
 * - Class definition.
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

namespace NelsonMartell\Test\DataProviders\ExampleClass;

use NelsonMartell\PropertiesHandler;
use NelsonMartell\ICustomPrefixedPropertiesContainer;

class C extends B implements ICustomPrefixedPropertiesContainer
{
    public function __construct()
    {
        parent::__construct();
        unset(
            $this->property5,
            $this->property6,
            $this->property7
        );
    }

    public static function getCustomGetterPrefix()
    {
        return 'getValueOf';
    }

    public static function getCustomSetterPrefix()
    {
        return 'setValueOf';
    }


    private $attribute5 = -5;

    public function getValueOfAttribute5()
    {
        return $this->attribute5 * 2;
    }

    private $attribute6 = -6;
    public $property6;

    protected function getValueOfProperty6()
    {
        return $this->attribute6;
    }

    protected function setValueOfProperty6($value)
    {
        $this->property6 = $value * 99;
    }

    private $attribute7 = -7;
    public $property7;

    /**
     * Wrong prefix getter; will never be called
     */
    protected function getProperty7()
    {
        return $this->property7;
    }
}
