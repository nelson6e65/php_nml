<?php

/**
 * PHP: Nelson Martell Library file
 *
 * Copyright © 2016-2020 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright 2016-2020 Nelson Martell
 * @link      http://nelson6e65.github.io/php_nml/
 * @since     v0.6.0
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

declare(strict_types=1);

namespace NelsonMartell\Test\DataProviders\ExampleClass;

use NelsonMartell\PropertiesHandler;
use NelsonMartell\IStrictPropertiesContainer;

/**
 * @internal
 *
 * @property string $magicProperty
 */
class WithoutMagicPropertiesClass implements IStrictPropertiesContainer
{
    use PropertiesHandler;

    public function __construct()
    {
        $this->magic_          = 'magic';
        $this->noMagicProperty = 'no magic';
    }

    /**
     *
     * @var string
     */
    private $magic_;

    /**
     *
     *
     * @return string
     */
    protected function getMagicProperty(): string
    {
        return $this->magic_;
    }

    /**
     *
     * @param string $value
     */
    protected function setMagicProperty(string $value)
    {
        $this->magic_ = $value;
    }

    /**
     *
     * @var string
     */
    private $noMagicProperty;

    /**
     *
     *
     * @return string
     */
    protected function getNoMagicProperty(): string
    {
        return $this->noMagicProperty;
    }

    /**
     *
     * @param string $value
     */
    protected function setNoMagicProperty(string $value)
    {
        $this->noMagicProperty = $value;
    }
}
