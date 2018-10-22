<?php

namespace App\API\V1\Classes\Specifications\Jsonapi;

use App\API\V1\Classes\Specifications\Jsonapi\Collections\ErrorCollection;
use App\API\V1\Classes\Specifications\Jsonapi\Objects\ErrorObject;

/**
 * Collection class
 *
 * @package  json-api
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
     * Get iterator
     *
     * @return \ArrayIterator|\Traversable
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->get());
    }

    /**
     * @param null $id
     * @param null $type
     *
     * @return array|ErrorCollection|ErrorObject
     */
    public function get($id = null, $type = null)
    {
        if ($id === null || $type === null) {
            return $this->collection;
        }

        $key = $id . '-' . $type;

        if (isset($this->collection[$key])) {
            return $this->collection[$key];
        }

        $error = $this->getErrorObject()
            ->setIdentifier('error')
            ->setHttpStatus(404)
            ->setTitle(__('There is no data in the collection'))
            ->setDetail(__('There is no data with :id in the collection', ['id' => $id . '-' . $type]));

        return $this->getErrorCollection()->add($error);
    }

    /**
     * Get count of object
     *
     * @return int
     */
    public function count(): int
    {
        return \count($this->get());
    }

    /**
     * Get error object
     *
     * @return ErrorObject
     */
    protected function getErrorObject(): ErrorObject
    {
        return new ErrorObject;
    }

    /**
     * Get error collection
     *
     * @return ErrorCollection
     */
    protected function getErrorCollection(): ErrorCollection
    {
        return new ErrorCollection;
    }
}
