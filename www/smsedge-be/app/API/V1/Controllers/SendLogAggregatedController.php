<?php

namespace App\API\V1\Controllers;

use App\API\V1\Classes\Argument\Argument;
use App\API\V1\Mappers\SendLogAggregatedMapper;
use App\API\V1\Services\SendLogAggregatedService;
use App\API\V1\Transformers\TransformerData;
use App\API\V1\Transformers\TransformerStrategy;
use App\API\V1\Validators\LogRequestParamValidator;
use App\Exceptions\ApiException;
use App\Exceptions\ValidationException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse as Response;

/**
 * API SMSEdge test
 * SendLogAggregated Controller class
 *
 * @package  api
 * @subpackage SMSEdge test
 * @author Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 * @filesource
 */
class SendLogAggregatedController extends BaseApiController
{
    /**
     * GET request
     *
     * @param int|null $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function index($id = null): Response
    {
        try {
            $this->request->attributes->add(['id' => $id]);

            $logService = new SendLogAggregatedService($this->request, new Argument, new SendLogAggregatedMapper($this->registry));

            if ($id !== null) {
                $logsData = $logService->validateRequest(new LogRequestParamValidator(['id']))->getSendLogsAggregated()->getData();
            } else {
                $logsData = $logService->validateRequest(new LogRequestParamValidator(['date_from', 'date_to']))->getSendLogsAggregated()->getData();
            }

            $collectData = (new TransformerData($this->request))
                ->setArguments($logService->getArguments())
                ->setData($logsData)
                ->setDataCount($logsData->count() === 1 ? 1 : $logService->getSendLogsAggregatedCount())
            ;

            $transformerClassName = "App\API\V1\Transformers\\{$this->format}\SendLogAggregated{$this->format}";
            $specificationClassName = "App\API\V1\Classes\Specifications\\{$this->format}\Specification{$this->format}";
            $transformer = new TransformerStrategy(new $transformerClassName(new $specificationClassName));

            return response()->json($transformer->getTransformedData($collectData));
        } catch (ApiException $ae) {
            if ($ae->getStatusCode() === 422) {
                return $this->wrongPropertyException($ae, $logService, 'SendLogAggregated');
            }

            return $this->getApiException($ae);
        }
        catch (QueryException $e) {
            return $this->getQueryException($e, 'SendLogAggregated');
        }
    }
}
