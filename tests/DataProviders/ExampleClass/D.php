<?php
/**
 * PHP: Nelson Martell Library file
 *
 * Content:
 * - Class definition.
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

namespace NelsonMartell\Test\DataProviders\ExampleClass;

use NelsonMartell as NML;
use NelsonMartell\Object;
use NelsonMartell\Extensions\String;
use NelsonMartell\PropertiesHandler;
use NelsonMartell\ICustomPrefixedPropertiesContainer;
use NelsonMartell\Test\Helpers\ExporterPlugin;
use \InvalidArgumentException;

class D extends C
{
    public function __construct()
    {
        parent::__construct();
        unset(
            $this->property9
        );
    }

    public static function getCustomGetterPrefix()
    {
        return 'get_';
    }

    public static function getCustomSetterPrefix()
    {
        return 'set_';
    }


    private $attribute8 = -8;

    public function get_attribute8()
    {
        return $this->attribute8;
    }

    private $attribute9 = -9;
    public $property9;

    protected function get_property9()
    {
        return $this->attribute9;
    }

    protected function set_property9($value)
    {
        $this->attribute9 = $value * 10;
    }
}
