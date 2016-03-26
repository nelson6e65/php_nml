<?php
/**
 * PHP: Nelson Martell Library file
 *
 * Content:
 * - Test helper for classes implementing ``NelsonMartell\IComparable`` interface
 *
 * Copyright © 2016 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright 2016 Nelson Martell
 * @link      http://nelson6e65.github.io/php_nml/
 * @since     v0.6.0
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

namespace NelsonMartell\Test;

use NelsonMartell as NML;
use NelsonMartell\Extensions\String;
use NelsonMartell\IComparable;
use NelsonMartell\Object;
use NelsonMartell\Version;
use NelsonMartell\Test\plugins\ExporterPlugin;
use \PHPUnit_Framework_TestCase as TestCase;
use \InvalidArgumentException;
use \ReflectionClass;
use \ReflectionException;
use \BadMethodCallException;
use \UnexpectedValueException;

/**
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * @internal
 * @group Criticals
 * */
trait TestConstructorHelper
{
    /**
     * Gets the name of class target of this test-class.
     *
     * @return string
     */
    public abstract function getTargetClassName();

    protected $targetClassReflection = null;


    public function getTargetClassReflection()
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
     * @return mixed Instance of target class.
     * @throws UnexpectedValueException
     * @throws BadMethodCallException
     */
    public function getTargetClassInstance()
    {
        return $this->getTargetClassReflection()->newInstanceArgs(func_get_args());
    }

    /**
     * @testdox Creates new instances.
     * @dataProvider goodConstructorArgumentsProvider
     */
    public function testConstructor()
    {
        $obj = call_user_func_array([$this, 'getTargetClassInstance'], func_get_args());
    }

    /**
     * @testdox Informs when error occurs on creating new instances.
     * @dataProvider badConstructorArgumentsProvider
     * @expectedException InvalidArgumentException
     */
    public function testConstructorWithBadArguments()
    {
        $obj = call_user_func_array([$this, 'getTargetClassInstance'], func_get_args());
    }

    /**
     * Must provide valid argument for constructor.
     *
     * @return array
     */
    public abstract function goodConstructorArgumentsProvider();

    /**
     * Must provide invalid argument for constructor.
     *
     * @return array
     */
    public abstract function badConstructorArgumentsProvider();
}
