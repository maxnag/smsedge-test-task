<?php

namespace App\API\V1\Classes\Specifications\Jsonapi\Objects;

/**
 * Link object
 *
 * @package json-api
 * @subpackage masterzoo masterzoo
 * @see http://jsonapi.org/format/#document-links (Links Information)
 * @author Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 * @filesource
 */
class LinkObject implements \IteratorAggregate {

    private $href = '';
    private $meta;

    /**
     * Get href
     *
     * @return string
     */
    public function getHref(): string
    {
        return $this->href;
    }

    /**
     * Set href
     *
     * @param string $href
     *
     * @return $this
     */
    public function setHref($href): self
    {
        $this->href = (string) $href;

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
     * Get link
     *
     * @param string $link
     *
     * @return mixed
     */
    public function __get($link)
    {
        return $this->{$link};
    }

    /**
     * Set link
     *
     * @param string $link
     * @param mixed $value
     *
     * @return $this
     */
    public function __set($link, $value)
    {
        $this->{$link} = $value;

        return $this;
    }

    /**
     * Check on property present
     *
     * @param string $link
     *
     * @return bool
     */
    public function __isset($link)
    {
        return isset($this->{$link});
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
}
