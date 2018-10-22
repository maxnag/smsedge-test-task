<?php

namespace App\API\V1\Services;

use App\API\V1\Classes\Argument\Argument;
use App\API\V1\Mappers\SendLogAggregatedMapper;
use App\API\V1\Entities\SendLogAggregatedEntity;
use App\API\V1\Collections\SendLogAggregatedCollection;
use App\API\V1\Validators\LogRequestParamValidator;
use App\Exceptions\ApiException;
use Dingo\Api\Http\Request;

/**
 * API SMSEdge test
 * SendLogAggregated Service class
 *
 * @package  api
 * @subpackage SMSEdge test
 * @author Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 * @filesource
 */
class SendLogAggregatedService extends ServiceAbstract
{
    /**
     * @var SendLogAggregatedMapper
     */
    private $sendLogAggregatedMapper;

    /**
     * @var SendLogAggregatedCollection
     */
    protected $data;

    /**
     * SendLogAggregated service constructor.
     *
     * @param Request $request
     * @param Argument $argument
     * @param SendLogAggregatedMapper $sendLogAggregatedMapper
     *
     * @throws \LogicException
     */
    public function __construct(Request $request, Argument $argument, SendLogAggregatedMapper $sendLogAggregatedMapper)
    {
        $this->request = $request;
        $this->sendLogAggregatedMapper = $sendLogAggregatedMapper;
        $this->arguments = $argument;
        $this->setArguments();
    }

    /**
     * Validate request params
     *
     * @param LogRequestParamValidator $validationObject
     *
     * @throws ApiException
     *
     * @return $this
     */
    public function validateRequest(LogRequestParamValidator $validationObject): self
    {
        $validationKeys = [];

        foreach (array_flip($validationObject->getRawData()) as $param => $value) {
            $validationKeys[$param] = null;
        }

        $requestParams = array_merge($validationKeys, (array) $this->arguments->getFilters());
        /** @var LogRequestParamValidator $validator */
        $validator = $validationObject->setData($requestParams);
        $this->setValidator($validator);

        if (!$validator->check()) {
            throw new ApiException(422, __('The :entity has validation mistakes.',
                ['entity' => 'CityEntity']));
        }

        return $this;
    }

    /**
     * Get sendLogsAggregated data
     *
     * @throws ApiException|\LogicException
     *
     * @return $this
     */
    public function getSendLogsAggregated(): self
    {
        if ($this->getValidator() === null) {
            throw new ApiException(404, __('The method :method firstly needs validation request.',
                ['method' => __METHOD__]));
        }

        $this->data = $this->sendLogAggregatedMapper->getSendLogsAggregatedData($this->arguments);

        return $this;
    }

    /**
     * Size of sendLogsAggregated data
     *
     * @return int
     */
    public function getSendLogsAggregatedCount(): int
    {
        if ($this->getValidator() === null) {
            throw new ApiException(404, __('The method :method firstly needs validation request.',
                ['method' => __METHOD__]));
        }

        return $this->sendLogAggregatedMapper->getSendLogsAggregatedDataCount($this->arguments);
    }

    /**
     * Get data
     *
     * @throws ApiException
     *
     * @return SendLogAggregatedCollection
     */
    public function getData(): SendLogAggregatedCollection
    {
        if ($this->data === null || empty($this->data->get())) {
            $this->notFoundException();
        }

        return $this->data;
    }
}
