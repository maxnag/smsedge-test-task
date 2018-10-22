<?php

namespace App\API\V1\Validators;

use Illuminate\Support\Facades\Validator;

/**
 * API SMSEdge test
 * Abstract class for validator data classes
 *
 * @package  api
 * @subpackage SMSEdge test
 * @author Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 * @filesource
 */
abstract class AbstractValidator
{
    /**
     * @var \Illuminate\Validation\Validator
     */
    protected $validator;

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var array
     */
    protected $rawData = [];

    /**
     * Validator_Abstract constructor.
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->setData($data);
    }

    /**
     * Set data
     *
     * @param array $data
     *
     * @return $this
     */
    public function setData(array $data): self
    {
        $this->rawData = $data;

        return $this;
    }

    /**
     * Get raw data
     *
     * @return array
     */
    public function getRawData(): array
    {
        return $this->rawData;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->validator !== null
            ? $this->validator->getData()
            : [];
    }

    /**
     * Get validation errors
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->validator !== null
            ? $this->validator->getMessageBag()->getMessages()
            : [];
    }

    /**
     * Get rules
     *
     * @return array
     */
    public function getRules(): array
    {
        return $this->prepareRules();
    }

    /**
     * Result of validation
     *
     * @return bool
     */
    public function check(): bool
    {
        $this->validator = Validator::make($this->getRawData(), $this->prepareRules(), $this->messages());

        if ($this->validator->passes()) {
            $this->data = $this->getData();

            return true;
        }

        return false;
    }

    /**
     * Rules for validation
     *
     * @return array
     */
    abstract protected function prepareRules(): array;

    /**
     * Custom massages for validation
     *
     * return array
     */
    abstract protected function messages(): array;
}
