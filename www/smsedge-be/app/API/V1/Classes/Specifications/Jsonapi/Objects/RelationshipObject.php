<?php

namespace App\API\V1\Classes\Specifications\Jsonapi\Objects;

use App\API\V1\Classes\Specifications\Jsonapi\Collections\ResourceCollection;

/**
 * Entity for relationship object
 *
 * @package  json-api
 * @subpackage masterzoo masterzoo
 * @see http://jsonapi.org/format/#document-resource-object-relationships (relationship Information)
 * @author Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 * @filesource
 */
class RelationshipObject implements \IteratorAggregate {

    /**
     * @var LinkObject
     */
    private $link;

    /**
     * @var ResourceCollection
     */
    private $data;

    /**
     * @var MetaObject
     */
    private $meta;

    /**
     * Get link entity
     *
     * @return null|LinkObject
     */
    public function getLink()
    {
        return $this->link ?? new LinkObject;
    }

    /**
     * Set link entity
     *
     * @param LinkObject $link
     *
     * @return $this
     */
    public function setLink(LinkObject $link): self
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get data entity
     *
     * @return null|ResourceCollection
     */
    public function getData()
    {
        return $this->data ?? new ResourceCollection;
    }

    /**
     * Set data entity
     *
     * @param ResourceCollection $data
     *
     * @return $this
     */
    public function setData(ResourceCollection $data): self
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get meta object
     *
     * @return null|MetaObject
     */
    public function getMeta()
    {
        return $this->meta ?? new MetaObject;
    }

    /**
     * Set meta object
     *
     * @param MetaObject $meta
     *
     * @return $this
     */
    public function setMeta(MetaObject $meta): self
    {
        $this->meta = $meta;

        return $this;
    }

    /**
     * Returns an iterator.
     *
     * @return \ArrayIterator
     */
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this);
    }

    /**
     * Get relationship
     *
     * @param string $relationship
     *
     * @return mixed
     */
    public function __get($relationship)
    {
        return $this->{$relationship};
    }

    /**
     * Set relationship
     *
     * @param string $relationship
     * @param $value mixed
     *
     * @return $this
     */
    public function __set($relationship, $value)
    {
        $this->{$relationship} = $value;

        return $this;
    }

    /**
     * Check on property present
     *
     * @param string $relationship
     *
     * @return bool
     */
    public function __isset($relationship)
    {
        return isset($this->{$relationship});
    }
}
