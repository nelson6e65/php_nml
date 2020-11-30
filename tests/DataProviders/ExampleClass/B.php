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

namespace NelsonMartell\Test\DataProviders\ExampleClass;

class B extends A
{
    public function __construct()
    {
        parent::__construct();
        unset(
            $this->property2,
            $this->property4
        );
    }

    // This is a wrapper for attribute2
    public $property2;

    /**
     * Sets attribute of parent class directly
     */
    public function setProperty2($value)
    {
        $this->attribute2 = $value; //This is accesible since is protected
    }

    public $property4;
    protected function getProperty4()
    {
        return $this->attribute4;
    }

    // ERRORS #########################################
    /**
     * Try to make read-only property accesible in this parent class
     * @throws \BadMethodCallException
     */
    protected function setProperty1($value)
    {
        $this->attribute1 = $value; //This is not accesible since is declared private in A
    }
}
