<?php

namespace App\API\V1\Classes;

use App\API\V1\Classes\Argument\Argument;
use App\Exceptions\ApiException;

/**
 * Map Identity implementation
 * Map Identity class
 *
 * @package  api
 * @subpackage SMSEdge test
 * @author Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 * @filesource
 */
class MapIdentity
{
    /**
     * @var array
     */
    private $objects = [];

    /**
     * Add object to map
     *
     * @param mixed $collection
     * @param Argument $arguments
     *
     * @throws ApiException
     *
     * @return void
     */
    public function addToMap($collection, Argument $arguments)
    {
        $this->objects[$this->prepareClassName($collection)][$this->prepareIdHash($arguments)] = $collection;
    }

    /**
     * Prepare class name
     *
     * @param mixed $collection
     *
     * @throws ApiException
     *
     * @return string
     */
    private function prepareClassName($collection): string
    {
        $typeCollection = \gettype($collection);
        $className = '';

        if (!\in_array($typeCollection, ['string', 'object'], false)) {
            throw new ApiException(405, __('The argument has not type string or object'));
        }

        if ($typeCollection === 'object') {
            $className = \get_class($collection);
        } elseif ($typeCollection === 'string') {
            $className = $collection;
        }

        if (!\class_exists($className)) {
            throw new ApiException(404, __('The class :class does not exist, maybe error in class name', ['class' => $className]));
        }

        return $className;
    }

    /**
     * Prepare has-key from arguments
     *
     * @param Argument $arguments
     *
     * @return string
     */
    private function prepareIdHash(Argument $arguments): string
    {
        return sha1(serialize($arguments));
    }

    /**
     * Get object from map
     *
     * @param mixed $collection
     * @param Argument $arguments
     *
     * @throws ApiException
     *
     * @return mixed
     */
    public function getFromMap($collection, Argument $arguments)
    {
        return $this->hasInMap($collection, $arguments)
            ? $this->objects[$this->prepareClassName($collection)][$this->prepareIdHash($arguments)]
            : false
        ;
    }

    /**
     * Checking is has map this object
     *
     * @param mixed $collection
     * @param Argument $arguments
     *
     * @throws ApiException
     *
     * @return bool
     */
    public function hasInMap($collection, Argument $arguments): bool
    {
        return isset($this->objects[$this->prepareClassName($collection)][$this->prepareIdHash($arguments)]);
    }

    /**
     * Remove object from map
     *
     * @param mixed $collection
     *
     * @throws ApiException
     *
     * @return void
     */
    public function removeFromMap($collection)
    {
        unset($this->objects[$this->prepareClassName($collection)]);
    }
}
