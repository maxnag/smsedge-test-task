<?php
namespace App\Exceptions;

use App\API\V1\Transformers\TransformerData;
use App\API\V1\Transformers\TransformerStrategy;
use Dingo\Api\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class ApiException
 *
 * @package  api
 * @subpackage academy masterzoo
 * @author Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 * @filesource
 */
class ApiException extends HttpException
{
    /**
     * ApiException constructor.
     *
     * @param string $statusCode
     * @param null $message
     * @param int $code
     * @param array $headers
     * @param \Exception|null $previous
     */
    public function __construct($statusCode, $message = null, $code = 0, array $headers = [],  \Exception $previous = null)
    {
        parent::__construct($statusCode, $message, $previous, $headers, $code);
    }

    /**
     * Output data
     *
     * @param Request $request
     *
     * @return array
     */
    public function getOutput(Request $request): array
    {
        $version = ucfirst($request->version());
        $format = ucfirst(strtolower($request->format()));

        $transformerClassName = "App\API\\{$version}\Transformers\\{$format}\Exception{$format}";
        $specificationClassName = "App\API\\{$version}\Classes\Specifications\\{$format}\Specification{$format}";
        $transformer = new TransformerStrategy(new $transformerClassName(new $specificationClassName));

        return $transformer->getErrorsData(
            (new TransformerData($request))->setData($this)
        );
    }

    /**
     * Get data
     *
     * @param $data
     *
     * @return mixed
     */
    public function __get($data)
    {
        return $this->{$data};
    }

    /**
     * Set data
     *
     * @param $data
     * @param $value
     *
     * @return $this
     */
    public function __set($data, $value)
    {
        $this->{$data} = $value;

        return $this;
    }

    /**
     * Check on property present
     *
     * @param string $data
     *
     * @return bool
     */
    public function __isset($data)
    {
        return isset($this->{$data});
    }
}