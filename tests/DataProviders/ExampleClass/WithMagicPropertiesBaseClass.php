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
use NelsonMartell\IMagicPropertiesContainer;
use NelsonMartell\IStrictPropertiesContainer;

/**
 * @internal
 *
 * @property string $baseProperty
 */
class WithMagicPropertiesBaseClass implements IStrictPropertiesContainer, IMagicPropertiesContainer
{
    use PropertiesHandler;

    public function __construct()
    {
        $this->baseProperty_ = 'base';
    }

    /**
     *
     * @var string
     */
    private $baseProperty_;

    /**
     *
     *
     * @return string
     */
    protected function getBaseProperty(): string
    {
        return $this->baseProperty_;
    }

    /**
     *
     * @param string $value
     */
    protected function setBaseProperty(string $value)
    {
        $this->baseProperty_ = $value;
    }
}
