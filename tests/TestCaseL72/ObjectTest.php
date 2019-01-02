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

namespace NelsonMartell\Test\TestCaseLt71;

use NelsonMartell as NML;
use NelsonMartell\Extensions\Text;
use NelsonMartell\Test\DataProviders\ObjectTestProvider;
use NelsonMartell\Object;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;
use Exception;

/**
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * @internal
 * @group Criticals
 * @requires PHP < 7.2.0
 *
 * */
class ObjectTest extends TestCase
{
    use ObjectTestProvider;

    /**
     * Overrides default tests, due to this class constructor do not throws argument exceptions.
     * So, using any type should be pass.
     *
     * @testdox Do not throws error on creating new instances, due to all arguments passed are ignored
     * @group Criticals
     */
    public function testConstructorWithBadArguments()
    {
        $actual = null;
        $message = Text::format(
            '$object = new {class}();',
            [
                'class' => Object::class,
            ]
        );

        try {
            $actual = new Object();
        } catch (Exception $e) {
            $actual = $e;
            $message .= Text::format(
                ' // # Constructor should not throws exceptions. Error: {0}',
                $this->exporter->export($e->getMessage())
            );
        }

        $this->assertInstanceOf(Object::class, $actual, $message);
    }
}
