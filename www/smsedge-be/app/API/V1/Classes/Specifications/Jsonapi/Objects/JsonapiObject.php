<?php

namespace App\API\V1\Classes\Specifications\Jsonapi\Objects;

/**
 * Jsonapi object
 *
 * @package  json-api
 * @subpackage masterzoo masterzoo
 * @see http://jsonapi.org/format/#document-jsonapi-object (JSON API Object Information)
 * @author Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 * @filesource
 */
class JsonapiObject
{
    /**
     * @var string
     */
    private $version = '1.0';

    /**
     * @var MetaObject
     */
    private $meta;

    /**
     * Get version
     *
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
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
     * Set meta entity
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
}
