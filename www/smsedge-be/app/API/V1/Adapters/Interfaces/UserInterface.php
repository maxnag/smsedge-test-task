<?php

namespace App\API\V1\Adapters\Interfaces;

use App\API\V1\Collections\UserCollection;
use App\API\V1\Entities\UserEntity;
use App\API\V1\Classes\Argument\Argument;

/**
 * User Adapter interface class
 *
 * @package api
 * @subpackage SMSEdge test
 * @author Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 * @filesource
 */
interface UserInterface
{
    /**
     * Get data method
     *  
     * @param Argument $arguments
     *
     * @return array|UserCollection
     */
    public function get(Argument $arguments): array;

    /**
     * Count data method
     *
     * @param Argument $arguments
     *
     * @return int
     */
    public function count(Argument $arguments): int;
}
