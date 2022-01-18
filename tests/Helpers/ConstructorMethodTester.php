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
 * @since     0.6.0
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

declare(strict_types=1);

namespace NelsonMartell\Test\Helpers;

use Throwable;
use ReflectionClass;
use ReflectionException;
use BadMethodCallException;
use UnexpectedValueException;
use PHPUnit\Framework\TestCase;

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
    abstract public function getTargetClassName(): string;



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
    public function getTargetClassReflection(): ReflectionClass
    {
        if ($this->targetClassReflection === null) {
            try {
                $this->targetClassReflection = new ReflectionClass($this->getTargetClassName());
            } catch (ReflectionException $e) {
                throw new BadMethodCallException('``getTargetClassName()`` is not returning a valid class name.', 1, $e);
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
    public function testConstructor(...$args): void
    {
        $this->getTargetClassInstance(...$args);

        /** @var TestCase $this */
        $this->assertTrue(true);
    }

    /**
     * @testdox Informs when error occurs on creating new instances
     * @dataProvider badConstructorArgumentsProvider
     *
     * @param string $exception Exception name
     * @param mixed  $args Constructor arguments
     */
    public function testConstructorWithBadArguments(string $exception, ...$args): void
    {
        /** @var TestCase $this */
        if (!is_subclass_of($exception, Throwable::class)) {
            $this->fail('dataProvider argument error: first argument must to be a Throwable name');
        }

        $this->expectException($exception);

        /** @var self $this */
        $this->getTargetClassInstance(...$args);
    }

    /**
     * Must provide valid argument for constructor.
     *
     * @return array
     */
    abstract public function goodConstructorArgumentsProvider(): array;

    /**
     * Must provide a exception class name and invalid arguments for constructor.
     *
     * @return array
     */
    abstract public function badConstructorArgumentsProvider(): array;
}
