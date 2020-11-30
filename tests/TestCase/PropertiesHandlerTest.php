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

namespace NelsonMartell\Test\TestCase;

use NelsonMartell\Test\DataProviders\PropertiesHandlerTestProvider;
use PHPUnit\Framework\TestCase;

/**
 * Tests for PropertiesHandler trait using test classes.
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * @internal
 * */
class PropertiesHandlerTest extends TestCase
{
    use PropertiesHandlerTestProvider;
}
