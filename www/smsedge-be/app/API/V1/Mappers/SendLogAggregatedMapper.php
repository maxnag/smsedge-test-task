<?php

namespace App\API\V1\Mappers;

use App\API\V1\SMSEdge\MySQL\SendLogAggregatedORMModel;
use App\API\V1\Adapters\Interfaces\SendLogAggregatedInterface;
use App\API\V1\Collections\SendLogAggregatedCollection;
use App\API\V1\Entities\CommonEntity;
use App\API\V1\Entities\SendLogAggregatedEntity;
use App\API\V1\Classes\Argument\Argument;
use App\API\V1\Classes\Registry;
use App\API\V1\Entities\UserEntity;
use App\API\V1\Services\CountryService;
use App\API\V1\Services\UserService;
use App\Exceptions\ApiException;
use Dingo\Api\Http\Request;

/**
 * API SMSEdge test
 * SendLogAggregated Mapper class
 *
 * @package  api
 * @subpackage SMSEdge test
 * @author Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 * @filesource
 */
class SendLogAggregatedMapper extends MapperAbstract
{
    /**
     * @var SendLogAggregatedInterface
     */
    private $adapter;

    /**
     * SendLogAggregatedMapper constructor.
     *
     * @param Registry $registry
     * @param mixed $adapterClassName
     *
     * @throws ApiException
     */
    public function __construct(Registry $registry, $adapterClassName = 'SendLogAggregatedMySQL')
    {
        $this->registry = $registry;
        $this->identityMap = $this->registry->get('Map');
        $this->adapter =\is_object($adapterClassName)
            ? $adapterClassName
            : $this->registry->get($adapterClassName)
        ;
    }

    /**
     * Get sendLogsAggregated data
     *
     * @param Argument $arguments
     *
     * @throws ApiException|\LogicException
     *
     * @return SendLogAggregatedCollection
     */
    public function getSendLogsAggregatedData(Argument $arguments): SendLogAggregatedCollection
    {
        $sendLogAggregatedCollection = new SendLogAggregatedCollection;

        $map = $this->identityMap->getFromMap($sendLogAggregatedCollection, $arguments);

        if ($map !== false) {
            return $map;
        }

        $sendLogsAggregatedData = $this->adapter->get($arguments);

        foreach ($sendLogsAggregatedData as $sendLogAggregatedData) {
            $sendLogAggregatedEntity = $this->getSendLogAggregatedEntity($sendLogAggregatedData);
            $sendLogAggregatedCollection->add($sendLogAggregatedEntity);
        }

        $this->identityMap->addToMap($sendLogAggregatedCollection, $arguments);

        return $sendLogAggregatedCollection;
    }

    /**
     * Size of sendLogsAggregated data
     *
     * @param Argument $arguments
     *
     * @return int
     */
    public function getSendLogsAggregatedDataCount(Argument $arguments): int
    {
        return $this->adapter->count($arguments);
    }

    /**
     * Convert sendLogAggregated data to sendLogAggregated entity
     *
     * @param \stdClass|SendLogAggregatedORMModel $sendLogAggregatedData
     *
     * @throw ApiException
     *
     * @return SendLogAggregatedEntity
     *
     */
    private function getSendLogAggregatedEntity($sendLogAggregatedData): SendLogAggregatedEntity
    {
        $sendLogAggregatedEntity = (new SendLogAggregatedEntity)
            ->setId($sendLogAggregatedData->id)
            ->setDate($sendLogAggregatedData->date)
            ->setUsrId($sendLogAggregatedData->usr_id)
            ->setUsrName($sendLogAggregatedData->usr_name)
            ->setCntCode($sendLogAggregatedData->cnt_code)
            ->setCntTitle($sendLogAggregatedData->cnt_title)
            ->setSuccess($sendLogAggregatedData->success)
            ->setFail($sendLogAggregatedData->fail)
        ;


        // @codeCoverageIgnoreStart
        $sendLogAggregatedEntity->setAuthor(
            function () use ($sendLogAggregatedEntity) {
                try {
                    $request = new Request;
                    $request->request->add(['id' => $sendLogAggregatedEntity->getUsrId()]);

                    $authorService = new UserService($request, new Argument, new UserMapper($this->registry));

                    $userCollection = $authorService->getUsers()->getData();

                    return $userCollection->get($sendLogAggregatedEntity->getUsrId());
                } catch (ApiException $ae) {
                    if ($ae->getStatusCode() === 404) {
                        return new UserEntity;
                    }

                    throw $ae;
                }
            }
        );

        $sendLogAggregatedEntity->setCountry(
            function () use ($sendLogAggregatedEntity) {
                try {
                    $request = new Request;
                    $request->query->add(['filter' => ['code' => $sendLogAggregatedEntity->getCntCode()]]);

                    $countryService = new CountryService($request, new Argument, new CountryMapper($this->registry));

                    $countryCollection = $countryService->getCountries()->getData();

                    $countryEntity = current($countryCollection->find('code', $sendLogAggregatedEntity->getCntCode()));

                    return $countryCollection->get($countryEntity->getId());
                } catch (ApiException $ae) {
                    if ($ae->getStatusCode() === 404) {
                        return new CommonEntity;
                    }

                    throw $ae;
                }
            }
        );
        // @codeCoverageIgnoreEnd

        return $sendLogAggregatedEntity;
    }
}
