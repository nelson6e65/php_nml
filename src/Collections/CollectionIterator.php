<?php
/**
 * PHP: Nelson Martell Library file
 *
 * Content:
 * - Trait definition:  [NelsonMartell\Collections]  CollectionIterator
 * - Class definition:  [NelsonMartell\Collections]  Collection
 *
 * Copyright © 2015-2017 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright 2015-2017 Nelson Martell
 * @link      http://nelson6e65.github.io/php_nml/
 * @since     0.4.0
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

namespace NelsonMartell\Collections;

/**
 * Implementa los métodos de la interfaz Iterator para una colección de objetos.
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * @since  0.4.0
 * */
trait CollectionIterator
{
    private $iteratorPosition = 0;

    public function current()
    {
        return $this->getItem($this->iteratorPosition);
    }

    public function rewind()
    {
        $this->iteratorPosition = 0;
    }

    public function key()
    {
        return $this->iteratorPosition;
    }

    public function next()
    {
        ++$this->iteratorPosition;
    }

    public function valid()
    {
        $v = (bool) ($this->getItem($this->iteratorPosition) != null);
        return $v;
    }

    protected abstract function getItem($index);
}
