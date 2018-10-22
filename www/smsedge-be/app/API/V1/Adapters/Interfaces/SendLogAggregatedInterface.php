<?php

namespace App\API\V1\Adapters\Interfaces;

use App\API\V1\Collections\SendLogAggregatedCollection;
use App\API\V1\Entities\SendLogAggregatedEntity;
use App\API\V1\Classes\Argument\Argument;

/**
 * SendLogAggregated Adapter interface class
 *
 * @package api
 * @subpackage SMSEdge test
 * @author Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 * @filesource
 */
interface SendLogAggregatedInterface
{
    /**
     * Get data method
     *
     * @param Argument $arguments
     *
     * @return array|SendLogAggregatedCollection
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
