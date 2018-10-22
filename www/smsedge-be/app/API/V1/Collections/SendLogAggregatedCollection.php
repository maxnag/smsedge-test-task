<?php

namespace App\API\V1\Collections;

use App\API\V1\Entities\SendLogAggregatedEntity;

/**
 * Collection entity for SendLogAggregated
 *
 * @package  api
 * @subpackage SMSEdge test
 * @author Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 * @filesource
 */
class SendLogAggregatedCollection extends CommonCollection
{
    /**
     * Add entity to collection
     *
     * @param SendLogAggregatedEntity $entity
     *
     * @return void
     */
    public function add(SendLogAggregatedEntity $entity): void
    {
        $this->collection[$entity->getId()] = $entity;
    }

    /**
     * Update entity in collection
     *
     * @param SendLogAggregatedEntity $entity
     *
     * @return void
     */
    public function updateEntity(SendLogAggregatedEntity $entity): void
    {
        $this->add($entity);
    }
}
