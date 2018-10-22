<?php

namespace App\API\V1\Mappers;

use App\API\V1\SMSEdge\MySQL\UserORMModel;
use App\API\V1\Adapters\Interfaces\UserInterface;
use App\API\V1\Collections\UserCollection;
use App\API\V1\Entities\UserEntity;
use App\API\V1\Classes\Argument\Argument;
use App\API\V1\Classes\Registry;
use App\Exceptions\ApiException;

/**
 * API SMSEdge test
 * User Mapper class
 *
 * @package  api
 * @subpackage SMSEdge test
 * @author Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 * @filesource
 */
class UserMapper extends MapperAbstract
{
    /**
     * @var UserInterface
     */
    private $adapter;

    /**
     * UserMapper constructor.
     *
     * @param Registry $registry
     * @param mixed $adapterClassName
     *
     * @throws ApiException
     */
    public function __construct(Registry $registry, $adapterClassName = 'UserMySQL')
    {
        $this->registry = $registry;
        $this->identityMap = $this->registry->get('Map');
        $this->adapter =\is_object($adapterClassName)
            ? $adapterClassName
            : $this->registry->get($adapterClassName)
        ;
    }

    /**
     * Get users data
     *
     * @param Argument $arguments
     *
     * @throws ApiException|\LogicException
     *
     * @return UserCollection
     */
    public function getUsersData(Argument $arguments): UserCollection
    {
        $userCollection = new UserCollection;

        $map = $this->identityMap->getFromMap($userCollection, $arguments);

        if ($map !== false) {
            return $map;
        }

        $usersData = $this->adapter->get($arguments);

        foreach ($usersData as $user) {
            $userEntity = $this->getUserEntity($user);
            $userCollection->add($userEntity);
        }

        $this->identityMap->addToMap($userCollection, $arguments);

        return $userCollection;
    }

    /**
     * Size of users data
     *
     * @param Argument $arguments
     *
     * @return int
     */
    public function getUsersDataCount(Argument $arguments): int
    {
        return $this->adapter->count($arguments);
    }

    /**
     * Convert user data to user entity
     *
     * @param \stdClass|UserORMModel $user
     *
     * @throw ApiException
     *
     * @return UserEntity
     *
     */
    private function getUserEntity($user): UserEntity
    {
        return (new UserEntity)
            ->setId($user->usr_id)
            ->setName($user->usr_name)
            ->setActive($user->usr_active)
            ->setDateCreate($user->usr_created)
            ->setDateModify($user->usr_modify)
        ;
    }
}
