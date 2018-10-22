<?php

namespace App\API\V1\Services;

use App\API\V1\Classes\Argument\Argument;
use App\Exceptions\ApiException;

/**
 * Service abstract class
 *
 * @codeCoverageIgnore
 *
 * @package  api
 * @subpackage SMSEdge test
 * @author Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 * @filesource
 */
abstract class ServiceAbstract
{
    /**
     * @var string
     */
    protected $format;

    /**
     * @var \Dingo\Api\Http\Request
     */
    protected $request;

    /**
     * @var \App\API\V1\Classes\Argument\Argument
     */
    protected $arguments;

    /**
     * @var object
     */
    protected $validator;

    /**
     * @var array
     */
    protected $fieldsEntity = [];

    /**
     * Get data
     *
     * @return object|array
     */
    abstract public function getData();

    /**
     * Get API format
     */
    public function getFormat(): string
    {
        $this->format = ucfirst(strtolower($this->request->format()));

        return $this->format;
    }

    /**
     * Get arguments
     *
     * @return Argument
     */
    public function getArguments(): Argument
    {
        return $this->arguments;
    }

    /**
     * Set arguments
     *
     * @throws \LogicException
     *
     * @return void
     */
    protected function setArguments()
    {
        $this->arguments
            ->setFilters(array_merge(['id' => $this->request->get('id')], ($this->request->query('filter') ?: []), ($this->request->attributes->all() ?: [])))
            ->setSorts($this->request->query('sort') ?: [])
            ->setPage($this->request->query('page') ?: [])
            ->setBody($this->request->getContent())
        ;
    }

    /**
     * Set validator object
     *
     * @param object $validator
     *
     * @return $this
     */
    protected function setValidator($validator): self
    {
        $this->validator = $validator;

        return $this;
    }

    /**
     * Get validator object
     *
     * @return object
     */
    public function getValidator()
    {
        return $this->validator;
    }

    /**
     * Not found exception
     * (wrapper for valid inspection code)
     *
     * @throws ApiException
     *
     * @return void
     */
    protected function notFoundException()
    {
        $apiException = new ApiException(404, __('No record found'));
        $apiException->detail_message = __('The entity you are looking for is not found in the database');

        throw $apiException;
    }

    /**
     * Cannot delete exception
     * (wrapper for valid inspection code)
     *
     * @throws ApiException
     *
     * @return void
     */
    protected function cannotDeleteException()
    {
        $apiException = new ApiException(409, __('Cannot delete record'));
        $apiException->detail_message = __('The record cannot be deleted. Something went wrong');

        throw $apiException;
    }
}
