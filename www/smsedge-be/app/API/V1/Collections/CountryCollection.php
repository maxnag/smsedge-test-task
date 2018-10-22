<?php

namespace App\API\V1\Collections;

use App\API\V1\Entities\CountryEntity;

/**
 * Collection entity for user
 *
 * @package  api
 * @subpackage SMSEdge test
 * @author Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 * @filesource
 */
class CountryCollection extends CommonCollection
{
    /**
     * Add entity to collection
     *
     * @param CountryEntity $entity
     *
     * @return void
     */
    public function add(CountryEntity $entity): void
    {
        $this->collection[$entity->getId()] = $entity;
    }

    /**
     * Update entity in collection
     *
     * @param CountryEntity $entity
     *
     * @return void
     */
    public function updateEntity(CountryEntity $entity): void
    {
        $this->add($entity);
    }
}
