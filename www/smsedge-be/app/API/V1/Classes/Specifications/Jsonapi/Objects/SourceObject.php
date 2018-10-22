<?php

namespace App\API\V1\Classes\Specifications\Jsonapi\Objects;

/**
 * Source object
 *
 * @package json-api
 * @subpackage masterzoo masterzoo
 * @see http://jsonapi.org/format/#errors (errors description)
 * @author Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 * @filesource
 */
class SourceObject
{
    private $pointer = '';
    private $parameter = '';

    /**
     * Get pointer
     *
     * @return string
     */
    public function getPointer(): string
    {
        return $this->pointer;
    }

    /**
     * Set pointer
     *
     * @param string $pointer
     *
     * @return $this
     */
    public function setPointer($pointer): self
    {
        $this->pointer = (string)$pointer;

        return $this;
    }

    /**
     * Get parameter
     *
     * @return string
     */
    public function getParameter(): string
    {
        return $this->parameter;
    }

    /**
     * Set parameter
     *
     * @param string $parameter
     *
     * @return $this
     */
    public function setParameter($parameter): self
    {
        $this->parameter = (string)$parameter;

        return $this;
    }
}
