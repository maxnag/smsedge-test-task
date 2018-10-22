<?php

namespace App\API\V1\Collections;

use App\API\V1\Entities\UserEntity;

/**
 * Collection entity for user
 *
 * @package  api
 * @subpackage SMSEdge test
 * @author Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 * @filesource
 */
class UserCollection extends CommonCollection
{
    /**
     * Add entity to collection
     *
     * @param UserEntity $entity
     *
     * @return void
     */
    public function add(UserEntity $entity): void
    {
        $this->collection[$entity->getId()] = $entity;
    }

    /**
     * Update entity in collection
     *
     * @param UserEntity $entity
     *
     * @return void
     */
    public function updateEntity(UserEntity $entity): void
    {
        $this->add($entity);
    }
}
