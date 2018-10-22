<?php

namespace App\API\V1\Controllers;

use App\API\V1\Classes\Argument\Argument;
use App\API\V1\Mappers\UserMapper;
use App\API\V1\Services\UserService;
use App\API\V1\Transformers\TransformerData;
use App\API\V1\Transformers\TransformerStrategy;
use App\Exceptions\ApiException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse as Response;

/**
 * API SMSEdge test
 * User Controller class
 *
 * @package  api
 * @subpackage SMSEdge test
 * @author Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 * @filesource
 */
class UserController extends BaseApiController
{
    /**
     * GET request
     *
     * @param int|null $id
     *
     * @return Response
     */
    public function index($id = null): Response
    {
        try {
            $this->request->attributes->add(['id' => $id]);

            $userService = new UserService($this->request, new Argument, new UserMapper($this->registry));
            $usersData = $userService->getUsers()->getData();

            $collectData = (new TransformerData($this->request))
                ->setArguments($userService->getArguments())
                ->setData($usersData)
                ->setDataCount($usersData->count() === 1 ? 1 : $userService->getUsersCount())
            ;

            $transformerClassName = "App\API\V1\Transformers\\{$this->format}\User{$this->format}";
            $specificationClassName = "App\API\V1\Classes\Specifications\\{$this->format}\Specification{$this->format}";
            $transformer = new TransformerStrategy(new $transformerClassName(new $specificationClassName));

            return response()->json($transformer->getTransformedData($collectData));
        } catch (ApiException $ae) {
            return $this->getApiException($ae);
        } catch (QueryException $e) {
            return $this->getQueryException($e, 'user');
        }
    }
}
