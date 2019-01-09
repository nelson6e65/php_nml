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
 * @since     0.6.0
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

namespace NelsonMartell\Test\Helpers;

use Throwable;
use ReflectionClass;
use ReflectionException;
use BadMethodCallException;
use UnexpectedValueException;

/**
 * Provides test methods and helpers to test class constructors.
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * @since 0.6.0
 * */
trait ConstructorMethodTester
{
    /**
     * Gets the name of class target of this test-class.
     *
     * @return string
     */
    abstract public function getTargetClassName() : string;

    /**
     *
     * @var ReflectionClass
     */
    protected $targetClassReflection = null;

    /**
     *
     * @return ReflectionClass
     * @throws BadMethodCallException
     */
    public function getTargetClassReflection() : ReflectionClass
    {
        if ($this->targetClassReflection === null) {
            try {
                if (!is_string($this->getTargetClassName())) {
                    throw new UnexpectedValueException('``getTargetClassName()`` is not returning an string.');
                }

                $this->targetClassReflection = new ReflectionClass($this->getTargetClassName());
            } catch (ReflectionException $e) {
                throw new BadMethodCallException('``getTargetClassName()`` is not returning a valid class name.');
            }
        }

        return $this->targetClassReflection;
    }

    /**
     * Gets (dinamically) an instance of target class using its constructor with the (optional) arguments.
     * It uses the ``getTargetClassName`` return value to determinate the name of target class.
     *
     * @param mixed  $args
     *
     * @return mixed Instance of target class.
     * @throws UnexpectedValueException
     * @throws BadMethodCallException
     */
    public function getTargetClassInstance(...$args)
    {
        return $this->getTargetClassReflection()->newInstanceArgs($args);
    }

    /**
     * @testdox Creates new instances
     * @dataProvider goodConstructorArgumentsProvider
     *
     * @param mixed  $args Constructor arguments
     */
    public function testConstructor(...$args) : void
    {
        $this->getTargetClassInstance(...$args);
    }

    /**
     * @testdox Informs when error occurs on creating new instances
     * @dataProvider badConstructorArgumentsProvider
     *
     * @param string $exception Exception name
     * @param mixed  $args Constructor arguments
     */
    public function testConstructorWithBadArguments(string $exception, ...$args) : void
    {
        if (!is_subclass_of($exception, Throwable::class)) {
            $this->fail('dataProvider argument error: first argument must to be a Throwable name');
        }

        $this->expectException($exception);

        $this->getTargetClassInstance(...$args);
    }

    /**
     * Must provide valid argument for constructor.
     *
     * @return array
     */
    abstract public function goodConstructorArgumentsProvider() : array;

    /**
     * Must provide a exception class name and invalid arguments for constructor.
     *
     * @return array
     */
    abstract public function badConstructorArgumentsProvider() : array;
}
