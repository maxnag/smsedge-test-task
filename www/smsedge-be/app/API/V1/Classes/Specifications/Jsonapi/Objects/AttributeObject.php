<?php

namespace App\API\V1\Classes\Specifications\Jsonapi\Objects;

/**
 * Attribute object
 *
 * @package  json-api
 * @subpackage masterzoo masterzoo
 * @see http://jsonapi.org/format/#document-resource-object-attributes (Attributes Information)
 * @author Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 * @filesource
 */
class AttributeObject
{

    /**
     * Get attribute
     *
     * @param string $attribute
     *
     * @return mixed
     */
    public function __get($attribute)
    {
        return $this->{$attribute};
    }

    /**
     * Set attribute
     *
     * @param string $attribute
     * @param mixed $value
     *
     * @return $this
     */
    public function __set($attribute, $value)
    {
        $this->{$attribute} = $value;

        return $this;
    }

    /**
     * Check on property present
     *
     * @param string $attribute
     *
     * @return bool
     */
    public function __isset($attribute)
    {
        return isset($this->{$attribute});
    }
}
