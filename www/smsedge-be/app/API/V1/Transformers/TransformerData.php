<?php

namespace App\API\V1\Transformers;

use App\API\V1\Classes\Argument\Argument;
use Dingo\Api\Http\Request;

/**
 * API SMSEdge test
 * Data class for converter data
 *
 * @package  api
 * @subpackage SMSEdge test
 * @author Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 * @filesource
 */
class TransformerData
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var Argument
     */
    private $arguments;

    /**
     * @var object|array
     */
    private $data;

    /**
     * @var int
     */
    private $dataCount = 0;

    /**
     * @var string
     */
    private $apiUrl;

    /**
     * @var string
     */
    private $apiVersion;

    /**
     * @var array
     */
    private $errors = [];

    /**
     * TransformerData constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->apiUrl = $request->root();
        $this->apiVersion = ucfirst($request->version());
    }

    /**
     * Get arguments object
     *
     * @return Argument
     */
    public function getArguments(): Argument
    {
        return $this->arguments;
    }

    /**
     * Set arguments object
     *
     * @param Argument $arguments
     *
     * @return $this
     */
    public function setArguments(Argument $arguments): self
    {
        $this->arguments = $arguments;

        return $this;
    }

    /**
     * Get data
     *
     * @return object
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set data
     *
     * @param object|array $data
     *
     * @return $this
     */
    public function setData($data) :self
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data size
     *
     * @return int
     */
    public function getDataCount(): int
    {
        return $this->dataCount;
    }

    /**
     * Set data size
     *
     * @param int $dataCount
     *
     * @return $this
     */
    public function setDataCount($dataCount): self
    {
        $this->dataCount = (int)$dataCount;

        return $this;
    }

    /**
     * Get api url
     *
     * @param bool $root
     *
     * @return string
     */
    public function getApiUrl($root = true): string
    {
        return $this->apiUrl . '/' . ($root ? '' : trim($this->request->route()->uri(), '/'));
    }

    /**
     * Get api version
     *
     * @return string
     */
    public function getApiVersion(): string
    {
        return $this->apiVersion;
    }

    /**
     * Get errors
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Set errors
     *
     * @param array $errors
     *
     * @return $this
     */
    public function setErrors($errors): self
    {
        $this->errors = $errors;

        return $this;
    }

    /**
     * Get request
     *
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }
}
