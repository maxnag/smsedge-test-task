<?php

namespace App\API\V1\Transformers;

use App\API\V1\Classes\Specifications\Jsonapi\Objects\LinkObject;
use App\API\V1\Classes\Specifications\Jsonapi\Objects\MetaObject;

/**
 * Adapter Transformer interface class
 *
 * @package api
 * @subpackage SMSEdge test
 * @author Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 * @filesource
 */
interface TransformerInterface
{
    /**
     * Get transformer data
     *
     * @param TransformerData $data
     *
     * @return array
     */
    public function getTransformedData(TransformerData $data): array;

    /**
     * Get errors data
     *
     * @param TransformerData $data
     *
     * @return array
     */
    public function getErrorsData(TransformerData $data): array;

    /**
     * Get meta information object
     *
     * @param TransformerData $data
     *
     * @return MetaObject
     */
    public function getMeta(TransformerData $data): MetaObject;

    /**
     * Get pagers links data
     *
     * @param TransformerData $data
     *
     * @return LinkObject
     */
    public function getPager(TransformerData $data): LinkObject;
}
