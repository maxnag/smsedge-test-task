<?php

namespace App\API\V1\Collections;

use App\Exceptions\ApiException;

/**
 * Collection common class
 *
 * @package  api
 * @subpackage SMSEdge test
 * @author Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 * @filesource
 */
class CommonCollection implements \IteratorAggregate, \Countable
{
    /**
     * Collection of entities
     *
     * @var array
     */
    protected $collection = [];

    /**
     * Add entity to collection use only for PHPUnit testing
     *
     * @param object $entity
     * @deprecated
     *
     * @return void
     */
    public function addForTestOnly( $entity)
    {
        $this->collection[$entity->getId()] = $entity;
    }

    /**
     * Search by collection
     *
     * @param mixed $property
     * @param mixed $value
     *
     * @return array
     */
    public function find($property = null, $value = null): array
    {
        $tmp = [];

        if ($property === null || $value === null) {
            return $tmp;
        }

        foreach ($this->collection as $entity) {
            if ($entity->{'get' . ucfirst($property)}() === $value) {
                $tmp[$entity->getId()] = $entity;
            }
        }

        return $tmp;
    }

    /**
     * Remove entity from collection
     *
     * @param int $id
     *
     * @throws ApiException
     *
     * @return array
     */
    public function remove($id): array
    {
        if (isset($this->collection[$id])) {
            unset($this->collection[$id]);

            return $this->collection;
        }

        throw new ApiException(404, __('The entity with ID :id does not found in collection  :collection',
            ['id' => $id, 'collection' => static::class])
        );
    }

    /**
     * Array Iterator
     *
     * @throws ApiException
     *
     * @return \ArrayIterator
     */
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->get());
    }

    /**
     * Get entity or entities from collection
     *
     * @param mixed $id
     *
     * @throws ApiException
     *
     * @return array|object
     */
    public function get($id = null)
    {
        if ($id === null) {
            return $this->collection;
        }

        if (isset($this->collection[$id])) {
            return $this->collection[$id];
        }

        throw new ApiException(404, __('The entity with ID :id does not found in collection :collection',
            ['id' => $id, 'collection' => static::class])
        );
    }

    /**
     * Size of collection
     *
     * @throws ApiException
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->get());
    }
}
