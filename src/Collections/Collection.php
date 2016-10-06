<?php
/**
 * PHP: Nelson Martell Library file
 *
 * Content:
 * - Trait definition:  [NelsonMartell\Collections]  CollectionIterator
 * - Class definition:  [NelsonMartell\Collections]  Collection
 *
 * Copyright © 2015-2016 Nelson Martell (http://nelson6e65.github.io)
 *
 * Licensed under The MIT License (MIT)
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright 2015-2016 Nelson Martell
 * @link      http://nelson6e65.github.io/php_nml/
 * @since     v0.4.0
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License (MIT)
 * */

namespace NelsonMartell\Collections;

use NelsonMartell\Extensions\String;
use NelsonMartell\Object;

/**
 * Clase base de una colección de objetos, que provee una implementación
 * predeterminada de la interfaz ICollection.
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * */
class Collection extends Object implements ICollection
{
    // Implementación de la interfaz Iterator.
    use CollectionIterator;

    public function __construct()
    {
        parent::__construct();
        unset($this->Count);
    }

    final public function __invoke($index, $value = null)
    {
        if ($value == null) {
            return $this->items[$index];
        }

        $this->setItem($index, $value);
    }

    private $items = array();


    /**
     * Inserta un nuevo elemento a la colección, en el índice especificado.
     *
     * @param integer $index   Índice del elemento a insertar.
     * @param mixed   $newItem Nuevo elemento a insertar a la colección.
     *
     * @return void
     * @access protected
     * */
    protected function insertItem($index, $newItem)
    {
        if ($index > $this->Count || $index < 0) {
            throw new OutOfRangeException();
        }

        if ($index == $this->Count) {
            $this->items[$index] = null;
            $this->count++;
        }

        $this->items[$index] = $newItem;
    }

    /**
     * Quita todos los elementos de la colección.
     *
     * @return void
     * */
    protected function clearItems()
    {
        $this->items = array();
        $this->count = 0;
    }

    /**
     * Establece un elemento en el índice especificado.
     *
     * @param integer $index   Índice del elemento a establecer.
     * @param mixed   $newItem Nuevo valor con el que se va a reemplazar.
     *
     * @return void
     * */
    protected function setItem($index, $newItem)
    {
        if ($index >= $this->Count || $index < 0) {
            throw new OutOfRangeException();
        }

        $this->items[$index] = $newItem;
    }

    /**
     * Obtiene el elemento almacenado en el índice especificado.
     * Este método no lanza excepción en caso de indicar un índice fuera del
     * rango; en cambio, devuelve NULL.
     * El elemento obtenido es de sólo lectura. Para modificar el elemento
     * dentro de la colección, tendría que utilizarse el método
     * Collection::setItem una vez modificado.
     *
     * @param integer $index Índice del elemento a obtener.
     *
     * @return mixed
     * */
    protected function getItem($index)
    {
        if ($index >= $this->Count || $index < 0) {
            return null;
        }

        return $this->items[$index];
    }

    /**
     * Remove the item in specified index.
     *
     * @param integer $index Index.
     *
     * @return void
     */
    protected function removeItem($index)
    {
        if ($index >= $this->Count || $index < 0) {
            throw new OutOfRangeException();
        }

        for ($i = $index; $i < $this->Count - 1; $i++) {
            $this->items[$i] = $this->items[$i + 1]; //Mueve los valores
        }

        unset($this->items[$this->Count - 1]); //Des-asigna el último elemento

        $this->count--;
    }

    /**
     * Gets the string representation of this object collection.
     *
     * You can format the output, by setting $format param to one of this
     * options:
     * - `R` or `r`: All items, separated by comma and space (`, `).
     *   This is the default format.
     * - `L` or `l`: Same as `r` option, but enclosed in braces  (`{`, `}`).
     * - `g`: A full string, containing class name, items count and items
     *   list (this list, like `L` option).
     * - `G`: Same as `g`, but using a full class name (including namespace).
     *
     * You can also use a custom format instead, using this placeholders:
     * - `{class}`: Short class name (without namespace part);
     * - `{nsclass}`: Full class name (included namespace);
     * - `{count}`: Items count; and
     * - `{items}`: List of items, using comma and space (`, `) as separator.
     *
     * Example: For a instance with 10 elements (numbers: 1-10), using:
     * `Collection::ToString('My collection ({count} items): { {items} }');`
     * Result: 'My collection (10 items): { 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 }'
     *
     * @param string $format String format (optional). By default, `r`.
     *
     * @return string
     * @see    String::format
     * */
    public function toString($format = 'r')
    {
        static $defaultFormats = [
            'r' => '{items}',
            'l' => '{ {items} }',
            'g' => '{class} ({count} items): { {items} }',
            'G' => '{nsclass} ({count} items): { {items} }',
        ];

        if ($format == null or !is_string($format)) {
            $format = 'r'; //Override if is not an string
        }

        $str = '';
        switch ($format) {
            case 'r':
            case 'l':
            case 'g':
            case 'G':
                $str = $defaultFormats[$format];
                break;

            default:
                $str = $format;
        }

        $t = $this->GetType();

        $items = implode(', ', $this->items);

        $placeHoldersValues = [
            'class'     => $t->ShortName,
            'nsclass'    => $t->Name,
            'count'     => $this->Count,
            'items'     => $items,
        ];


        $s = String::Format($str, $placeHoldersValues);

        return $s;
    }



    /**
     * Obtiene el número de elementos incluidos en la colección.
     * Esta propiedad es de sólo lectura.
     *
     * @var integer
     * */
    public $Count;
    private $count = 0;

    /**
     * Getter for Count property.
     *
     * @return integer
     * */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Agrega un nuevo elemento al final de la colección.
     * Nota para herederos: Para cambiar el comportamiento de este método,
     * reemplazar más bien el método protegido 'InsertItem'.
     *
     * @param mixed $item Elemento que se va a agregar a la colección.
     *
     * @return void
     * */
    public function add($item)
    {
        $this->InsertItem($this->Count, $item);
    }

    /**
     * Quita todos los elementos de la colección.
     * Nota para herederos: Para cambiar el comportamiento de este método,
     * reemplazar más bien el método protegido `Collection::clearItems`.
     *
     * @return void
     * @see    Collection::clearItems
     * */
    public function clear()
    {
        $this->clearItems();
    }

    /**
     * Determina si la colección contiene al elemento especificado.
     *
     * @param mixed $item Objeto que se va a buscar.
     *
     * @return boolean `true` si $item se encuentra; en caso contrario, `false`.
     * */
    public function contains($item)
    {
        foreach ($this->items as $i) {
            if ($item === $i) {
                return true;
            }
        }

        return false;
    }

    /**
     * Quita, si existe, la primera aparición de un objeto específico de la
     * colección.
     *
     * @param mixed $item Objeto que se va a quitar.
     *
     * @return boolean `true` si el elemento se ha quitado correctamente; en
     *   caso contrario, `false`. Este método también devuelve `false` si no
     *   se encontró.
     * */
    public function remove($item)
    {
        for ($i = 0; $i < $this->Count; $i++) {
            if ($this->items[$i] === $item) {
                $this->RemoveItem($i);
            }
        }

        return false;
    }
}
