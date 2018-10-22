<?php

namespace App\API\V1\Classes\Argument;

/**
 * API masterzoo masterzoo
 * Filter class
 *
 * @package core
 * @subpackage masterzoo masterzoo
 * @author Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 * @filesource
 */
class Filter implements \IteratorAggregate
{
    /**
     * Set filter data
     *
     * @param array $filters
     *
     * @return $this
     */
    public function set(array $filters = []): self
    {
        foreach ($filters as $property => $value) {
            if (isset($this->{$property})) {
                continue;
            }

            $this->{$property} = $value;
        }

        return $this;
    }

    /**
     * Array Iterator
     *
     * @return \ArrayIterator
     */
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this);
    }

    /**
     * Get filter data
     *
     * @param string $filter
     *
     * @return mixed
     */
    public function __get($filter)
    {
        return $this->{$filter};
    }

    /**
     * Set data of filter
     *
     * @param string $filter
     * @param mixed $value
     *
     * @return $this
     */
    public function __set($filter, $value)
    {
        $this->{$filter} = $value;

        return $this;
    }

    /**
     * Check on property present
     *
     * @param string $filter
     *
     * @return bool
     */
    public function __isset($filter)
    {
        return isset($this->{$filter});
    }
}
