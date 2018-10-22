<?php

namespace App\API\V1\Classes\Argument;

/**
 * Collection class
 *
 * @package  api
 * @subpackage masterzoo masterzoo
 * @author Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 * @filesource
 */
class Collection implements \IteratorAggregate, \Countable
{
    /**
     * @var array
     */
    protected $collection = [];

    /**
     * Add item to collection
     *
     * @param \stdClass $sort
     */
    public function add($sort)
    {
        $this->collection[] = $sort;
    }

    /**
     * Get iterator
     *
     * @return \ArrayIterator
     */
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->get());
    }

    /**
     * Get collection
     *
     * @return array
     */
    public function get(): array
    {
        return $this->collection;
    }

    /**
     * Get size of collection
     *
     * @return int
     */
    public function count(): int
    {
        return \count($this->get());
    }
}
