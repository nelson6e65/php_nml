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
 * @since     0.6.0
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

declare(strict_types=1);

namespace NelsonMartell\Test\DataProviders;

use NelsonMartell\StrictObject;
use NelsonMartell\Test\Helpers\ExporterPlugin;
use NelsonMartell\Test\Helpers\IComparerTester;

/**
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * @since  0.6.0
 * @internal
 * */
trait StrictObjectTestProvider
{
    use ExporterPlugin;

    public function getTargetClassName(): string
    {
        return StrictObject::class;
    }
}
