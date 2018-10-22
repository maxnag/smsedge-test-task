<?php

namespace App\API\V1\Controllers;

use App\API\V1\Classes\Registry;
use App\API\V1\Services\ServiceAbstract;
use App\API\V1\Transformers\TransformerData;
use App\API\V1\Transformers\TransformerStrategy;
use App\Exceptions\ApiException;
use App\Exceptions\ValidationException;
//use App\Notifications\ErrorsLog;
use Dingo\Api\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse as Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;

/**
 * API SMSEdge test
 * Base Controller class
 *
 * @package  api
 * @subpackage SMSEdge test
 * @author Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 * @filesource
 */
class BaseApiController extends Controller
{
//    use Notifiable;

    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @var string
     */
    protected $format;

    /**
     * @var \Dingo\Api\Http\Request
     */
    protected $request;

    /**
     * SendLogAggregatedController constructor.
     * 
     * @param Request $request
     * 
     * @throw ApiException
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->registry = new Registry($request->version());
        $this->format = ucfirst(strtolower($request->format()));
    }

    /**
     * Get Request
     *
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * DB connection
     * (wrapper for valid inspection code)
     *
     * @param string $group
     *
     * @return \Illuminate\Database\Connection|\Illuminate\Database\Concerns\ManagesTransactions|\stdClass
     */
    protected function dbConnection($group)
    {
        return DB::connection($group);
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

    /**
     * Wrong property exception
     * (wrapper for valid inspection code)
     *
     * @param ApiException $ae
     * @param ServiceAbstract $service
     * @param string $name
     *
     * @return Response
     *
     * @throws \Exception
     */
    protected function wrongPropertyException($ae, $service, $name): Response
    {
        if (!empty($service->getValidator())) {
            $collectData = (new TransformerData($this->request))
                ->setErrors($service->getValidator()->getErrors())
                ->setData($service->getValidator()->getData());
            $transformerClassName = "App\API\V1\Transformers\\{$this->format}\\{$name}{$this->format}";
            $specificationClassName = "App\API\V1\Classes\Specifications\\{$this->format}\Specification{$this->format}";
            $transformer = new TransformerStrategy(new $transformerClassName(new $specificationClassName));

            return response()->json($transformer->getErrorsData($collectData), 422);
        }

        return $this->getApiException($ae);
    }

    /**
     * @param ApiException $ae
     *
     * @return Response
     */
    protected function getApiException($ae): Response
    {
        report($ae);

//        if (!\in_array($ae->getStatusCode(), [404, 422])) {
//            $this->notify(new ErrorsLog($ae));
//        }

        return response()->json(
            $ae->getOutput($this->request),
            $ae->getStatusCode(),
            $ae->getHeaders()
        );
    }

    /**
     * @param ValidationException $ve
     *
     * @return Response
     */
    protected function getValidationException($ve): Response
    {
        report($ve);

        return response()->json($ve->getOutput(), 422);
    }

    /**
     * Get Query exception
     *
     * @param \Illuminate\Database\QueryException $e
     * @param string $entity
     *
     * @return Response
     */
    protected function getQueryException($e, $entity = ''): Response
    {
        report($e);

//        $this->notify(new ErrorsLog($e));

        switch ($e->errorInfo[1])
        {
            case 1054:
                $apiException = new ApiException(409, __('SQL error'));
                $apiException->detail_message = __('SQL query has the error - :sql', ['sql' => $e->errorInfo[2]]);
                break;
            case 1062:
                $apiException = new ApiException(409, __('Duplicate record'));
                $apiException->detail_message = __('This :entity exists in database', ['entity' => __($entity)]);
                break;
            case 1064:
                $apiException = new ApiException(409, __('SQL error'));
                $apiException->detail_message = __('SQL query has the error - :sql', ['sql' => $e->errorInfo[2]]);
                break;
            case 1452:
                $apiException = new ApiException(403, __('An error in foreign key'));
                $apiException->detail_message = __('A foreign key constraint fails');
                break;
            default:
                $apiException = new ApiException(409, __('Something went wrong'));
                $apiException->detail_message = $e->getCode();
        }

//        $this->notify(new ErrorsLog($apiException));

        return response()->json(
            $apiException->getOutput($this->request),
            $apiException->getStatusCode(),
            $apiException->getHeaders()
        );
    }
}
