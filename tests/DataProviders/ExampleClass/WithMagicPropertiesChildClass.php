<?php

/**
 * PHP: Nelson Martell Library file
 *
 * Copyright © 2016-2021 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright 2016-2021 Nelson Martell
 * @link      http://nelson6e65.github.io/php_nml/
 * @since     1.0.0
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

declare(strict_types=1);

namespace NelsonMartell\Test\DataProviders\ExampleClass;

/**
 * @internal
 * @property string      $childProperty
 * @property-read string $readOnlyChildProperty
 *
 * @since 1.0.0
 */
class WithMagicPropertiesChildClass extends WithMagicPropertiesBaseClass
{
    /**
     * [__construct description]
     *
     * @param int $readOnlyChildProperty
     */
    public function __construct($readOnlyChildProperty = 1)
    {
        $this->childProperty_         = 'child';
        $this->readOnlyChildProperty_ = $readOnlyChildProperty;
    }

    /**
     *
     * @var string
     */
    private $childProperty_;

    /**
     *
     *
     * @var int
     */
    private $readOnlyChildProperty_ = -1;


    /**
     *
     *
     * @return string
     */
    protected function getChildProperty(): string
    {
        return $this->childProperty_;
    }

    /**
     *
     * @param string $value
     */
    protected function setChildProperty(string $value)
    {
        $this->childProperty_ = $value;
    }


    /**
     *
     *
     * @return int
     */
    protected function getReadOnlyChildProperty(): int
    {
        return $this->readOnlyChildProperty_;
    }
}
