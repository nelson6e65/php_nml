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
 * @since     v0.6.0
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

namespace NelsonMartell\Test\TestCase;

use NelsonMartell\Test\DataProviders\StrictObjectTestProvider;

use PHPUnit\Framework\TestCase;

/**
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * @internal
 * @group Criticals
 * */
class StrictObjectTest extends TestCase
{
    use StrictObjectTestProvider;

    public function testExists() : void
    {
        $this->assertTrue(true);
    }
}
