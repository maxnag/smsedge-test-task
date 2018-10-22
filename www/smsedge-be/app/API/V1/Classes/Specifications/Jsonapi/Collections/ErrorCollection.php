<?php

namespace App\API\V1\Classes\Specifications\Jsonapi\Collections;

use App\API\V1\Classes\Specifications\Jsonapi\Collection;
use App\API\V1\Classes\Specifications\Jsonapi\Objects\ErrorObject;

/**
 * Collection entity for error
 *
 * @package  json-api
 * @subpackage masterzoo masterzoo
 * @see http://jsonapi.org/format/#errors (errors description)
 * @author Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 * @filesource
 */
class ErrorCollection extends Collection
{
    /**
     * @param ErrorObject $object
     *
     * @return $this
     */
    public function add(ErrorObject $object)
    {
        $this->collection[$object->getIdentifier() . '-'] = $object;

        return $this;
    }

    /**
     * @param ErrorObject $object
     *
     * @return $this
     */
    public function update(ErrorObject $object)
    {
        $this->add($object);

        return $this;
    }
}
