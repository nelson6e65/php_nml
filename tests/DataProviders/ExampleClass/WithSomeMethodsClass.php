<?php declare(strict_types=1);
/**
 * PHP: Nelson Martell Library file
 *
 * Copyright © 2019 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright 2019 Nelson Martell
 * @link      http://nelson6e65.github.io/php_nml/
 * @since     1.0.0
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

namespace NelsonMartell\Test\DataProviders\ExampleClass;

use BadMethodCallException;


/**
 * @internal
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * @since 1.0.0
 *
 * @method string magicMethod()
 */
class WithSomeMethodsClass
{
    /**
     *
     */
    private function privateMethod() : void
    {
    }

    /**
     *
     */
    protected function protectedMethod() : void
    {
    }

    /**
     *
     */
    public function publicMethod() : void
    {
    }

    /**
     *
     *
     * @param  string $name
     * @param  array  $arguments
     *
     * @return
     */
    public function _call(string $name, array $arguments = [])
    {
        if ($name === 'magicMethod') {
            return 'string';
        }

        throw new BadMethodCallException($name.' method do not exists.');
    }
}
