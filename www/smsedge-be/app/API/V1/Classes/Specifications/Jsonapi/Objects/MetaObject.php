<?php

namespace App\API\V1\Classes\Specifications\Jsonapi\Objects;

/**
 * Entity for meta
 *
 * @package json-api
 * @subpackage masterzoo masterzoo
 * @see http://jsonapi.org/format/#document-meta (Meta Information)
 * @author Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 * @filesource
 */
class MetaObject {

    /**
     * Get meta
     *
     * @param string $meta
     *
     * @return string
     */
    public function __get($meta)
    {
        return $this->{$meta};
    }

    /**
     * Set meta
     *
     * @param string $meta
     * @param mixed $value
     *
     * @return $this
     */
    public function __set($meta, $value)
    {
        $this->{$meta} = $value;

        return $this;
    }

    /**
     * Check on property present
     *
     * @param string $meta
     *
     * @return bool
     */
    public function __isset($meta)
    {
        return isset($this->{$meta});
    }
}
