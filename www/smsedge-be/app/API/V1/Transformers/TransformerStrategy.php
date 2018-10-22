<?php

namespace App\API\V1\Transformers;

use App\API\V1\Transformers\Jsonapi\CountryJsonapi;
use App\API\V1\Transformers\Jsonapi\SendLogAggregatedJsonapi;
use App\API\V1\Transformers\Jsonapi\ExceptionJsonapi;
use App\API\V1\Transformers\Jsonapi\UserJsonapi;

/**
 * API SMSEdge test
 * TransformerStrategy class
 *
 * @package  api
 * @subpackage SMSEdge test
 * @author Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 * @filesource
 */
class TransformerStrategy
{
    /**
     * @var object
     */
    private $strategy;

    /**
     * TransformerStrategy constructor.
     *
     * @param object|ExceptionJsonapi|SendLogAggregatedJsonapi|CountryJsonapi|UserJsonapi $transformedObject
     */
    public function __construct($transformedObject)
    {
        $this->strategy = $transformedObject;
    }

    /**
     * Get transformed data
     *
     * @param TransformerData $data
     *
     * @return array
     */
    public function getTransformedData(TransformerData $data): array
    {
        return $this->strategy->getTransformedData($data);
    }

    /**
     * Get errors data
     *
     * @param TransformerData $data
     *
     * @throws \Exception
     *
     * @return array
     */
    public function getErrorsData(TransformerData $data): array
    {
        return $this->strategy->getErrorsData($data);
    }

}
