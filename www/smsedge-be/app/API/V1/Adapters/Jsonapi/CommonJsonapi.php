<?php

namespace App\API\V1\Adapters\Jsonapi;

use App\API\V1\Classes\Argument\Argument;
use App\Exceptions\ApiException;
use Dingo\Api\Http\Request;

/**
 * JsonAPI common Adapter class
 *
 * @package  api
 * @subpackage SMSEdge test
 * @author Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 * @filesource
 */
class CommonJsonapi
{
    /**
     * @var array
     */
    protected $propertyOfEntity;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var string
     */
    protected $action = 'POST';

    /**
     * @var array
     */
    protected $mapping = [];

    /**
     * Adapter_Json_Common constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Set properties of entity object
     *
     * @param array $entity
     *
     * @return $this
     */
    public function setEntity($entity)
    {
        $this->propertyOfEntity = $entity;

        return $this;
    }

    /**
     * Set action
     *
     * @param string|null $action
     *
     * @return $this
     */
    public function setAction($action = null)
    {
        $this->action = $action ?? $this->action;

        return $this;
    }

    /**
     * Get mapping fields
     *
     * @return array
     */
    public function getMappingFields(): array
    {
        return $this->mapping;
    }

    /**
     * Get data
     *
     * @param Argument $arguments
     *
     * @throws ApiException
     *
     * @return array
     */
    public function get(Argument $arguments): array
    {
        $values = $this->jsonDecode($arguments->getBody());

        $this->checkNecessaryParams($values);

        $data = new \stdClass;

        $attributes = [];

        if (!empty($values->data)) {
            $attributes = (new \ArrayObject($values->data->attributes))->count();
        }

        if (!empty($values) && !empty($attributes)) {
            foreach ($this->propertyOfEntity as $property => $val) {
                $data->{$property} = $this->checkProperty($values->data->attributes, $property);
            }

            if (!empty($values->data->id)) {
                $data->id = $values->data->id;
            }
        } else {
            $apiException = new ApiException(404, __('Data is absent'));
            $apiException->detail_message = __('No data to write');

            throw $apiException;
        }

        return [$data];
    }

    /**
     * Magic method call
     *
     * @param string $name
     * @param array $arguments
     *
     * @throws ApiException
     */
    public function __call($name, $arguments)
    {
        $apiException = new ApiException(409, 'The action not available');
        $apiException->detail_message = __('The action :name not available in the request', ['name' => $name]);

        throw $apiException;
    }

    /**
     * Json decode
     *
     * @param string $json
     *
     * @throws ApiException
     *
     * @return mixed
     */
    protected function jsonDecode($json)
    {
        $value = json_decode($json);
        $jsonDecodeError = '';

        // @codeCoverageIgnoreStart
        switch (json_last_error())
        {
            case JSON_ERROR_DEPTH:
                $jsonDecodeError = __('The maximum stack depth has been exceeded');
                break;
            case JSON_ERROR_STATE_MISMATCH:
                $jsonDecodeError = __('Occurs with underflow or with the modes mismatch');
                break;
            case JSON_ERROR_CTRL_CHAR:
                $jsonDecodeError = __('Control character error, possibly incorrectly encoded');
                break;
            case JSON_ERROR_SYNTAX:
                $jsonDecodeError = __('Syntax error');
                break;
            case JSON_ERROR_UTF8:
                $jsonDecodeError = __('Malformed UTF-8 characters, possibly incorrectly encoded');
                break;
        }
        // @codeCoverageIgnoreEnd

        if (!empty($jsonDecodeError))
        {
            $apiException = new ApiException(403, __('Error in decoding input JSON'));
            $apiException->detail_message = $jsonDecodeError;

            throw $apiException;
        }

        return $value;
    }

    /**
     * Check necessary params
     *
     * @param \stdClass $values
     *
     * @throws ApiException
     *
     * @return void
     */
    protected function checkNecessaryParams($values)
    {
        if (empty($values->data->type) && 'POST' === $this->request->getMethod()) // create
        {
            $apiException = new ApiException(409, __('The required parameters are empty'));
            $apiException->detail_message = __('Parameter "Type" must present in request and not be empty');

            throw $apiException;
        }

        if ((empty($values->data->type) || empty($values->data->id)) && 'PATCH' === $this->request->getMethod()) //update
        {
            $apiException = new ApiException(409, __('The required parameters are empty'));
            $apiException->detail_message = __('Parameters "Type" or "ID" must present in request and not be empty');

            throw $apiException;
        }
    }

    /**
     * Mapping property of entity on incoming attribute
     *
     * @param \stdClass $object
     * @param string $property
     *
     * @return mixed
     */
    protected function checkProperty($object, $property)
    {
        if (property_exists($object, $property))
        {
            $this->mapping[] = $property;
        }

        return !empty($object->{$property}) ? $object->{$property} : null;
    }
}
