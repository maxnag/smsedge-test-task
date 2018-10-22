<?php

namespace App\API\V1\Adapters\Interfaces;

use App\API\V1\Collections\CountryCollection;
use App\API\V1\Entities\CountryEntity;
use App\API\V1\Classes\Argument\Argument;

/**
 * Country Adapter interface class
 *
 * @package api 
 * @subpackage SMSEdge test
 * @author Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 * @filesource
 */
interface CountryInterface
{
    /**
     * Get data method
     *  
     * @param Argument $arguments
     *
     * @return array|CountryCollection
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
