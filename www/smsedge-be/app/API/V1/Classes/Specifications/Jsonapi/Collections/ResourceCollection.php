<?php

namespace App\API\V1\Classes\Specifications\Jsonapi\Collections;

use App\API\V1\Classes\Specifications\Jsonapi\Objects\ResourceObject;
use App\API\V1\Classes\Specifications\Jsonapi\Collection;

/**
 * Collection entity for resource
 *
 * @package  json-api
 * @subpackage masterzoo masterzoo
 * @see http://jsonapi.org/format/#document-resource-objects (resource description)
 * @author Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 * @filesource
 */
class ResourceCollection extends Collection
{

    /**
     * @param ResourceObject $entity
     *
     * @return $this
     */
    public function add(ResourceObject $entity)
    {
        $this->collection[$entity->getId() . '-' . $entity->getType()] = $entity;

        return $this;
    }

    /**
     * @param ResourceObject $entity
     *
     * @return $this
     */
    public function update(ResourceObject $entity)
    {
        $this->add($entity);

        return $this;
    }
}
