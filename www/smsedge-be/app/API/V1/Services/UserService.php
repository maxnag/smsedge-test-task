<?php

namespace App\API\V1\Services;

use App\API\V1\Classes\Argument\Argument;
use App\API\V1\Mappers\UserMapper;
use App\API\V1\Entities\UserEntity;
use App\API\V1\Collections\UserCollection;
use App\Exceptions\ApiException;
use Dingo\Api\Http\Request;

/**
 * API SMSEdge test
 * User Service class
 *
 * @package  api
 * @subpackage SMSEdge test
 * @author Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 * @filesource
 */
class UserService extends ServiceAbstract
{
    /**
     * @var UserMapper
     */
    private $userMapper;

    /**
     * @var UserCollection
     */
    protected $data;

    /**
     * User service constructor.
     *
     * @param Request $request
     * @param Argument $argument
     * @param UserMapper $userMapper
     *
     * @throws \LogicException
     */
    public function __construct(Request $request, Argument $argument, UserMapper $userMapper)
    {
        $this->request = $request;
        $this->userMapper = $userMapper;
        $this->arguments = $argument;
        $this->setArguments();
    }

    /**
     * Get users data
     *
     * @throws ApiException|\LogicException
     *
     * @return $this
     */
    public function getUsers(): self
    {
        $this->data = $this->userMapper->getUsersData($this->arguments);

        return $this;
    }

    /**
     * Size of users data
     *
     * @return int
     */
    public function getUsersCount(): int
    {
        return $this->userMapper->getUsersDataCount($this->arguments);
    }

    /**
     * Set data
     *
     * @param UserEntity $userEntity
     *
     * @return $this
     */
    public function setData(UserEntity $userEntity): self
    {
        $userCollection = new UserCollection;
        $userCollection->add($userEntity);

        $this->data = $userCollection;

        return $this;
    }

    /**
     * Get data
     *
     * @throws ApiException
     *
     * @return UserCollection
     */
    public function getData(): UserCollection
    {
        if ($this->data === null || empty($this->data->get())) {
            $this->notFoundException();
        }

        return $this->data;
    }
}
