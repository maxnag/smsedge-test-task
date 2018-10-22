<?php

namespace App\API\V1\Mappers;

use App\API\V1\SMSEdge\MySQL\CountryORMModel;
use App\API\V1\Adapters\Interfaces\CountryInterface;
use App\API\V1\Collections\CountryCollection;
use App\API\V1\Entities\CountryEntity;
use App\API\V1\Classes\Argument\Argument;
use App\API\V1\Classes\Registry;
use App\Exceptions\ApiException;

/**
 * API SMSEdge test
 * Country Mapper class
 *
 * @package  api
 * @subpackage SMSEdge test
 * @author Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 * @filesource
 */
class CountryMapper extends MapperAbstract
{
    /**
     * @var CountryInterface
     */
    private $adapter;

    /**
     * CountryMapper constructor.
     *
     * @param Registry $registry
     * @param mixed $adapterClassName
     *
     * @throws ApiException
     */
    public function __construct(Registry $registry, $adapterClassName = 'CountryMySQL')
    {
        $this->registry = $registry;
        $this->identityMap = $this->registry->get('Map');
        $this->adapter =\is_object($adapterClassName)
            ? $adapterClassName
            : $this->registry->get($adapterClassName)
        ;
    }

    /**
     * Get countries data
     *
     * @param Argument $arguments
     *
     * @throws ApiException|\LogicException
     *
     * @return CountryCollection
     */
    public function getCountriesData(Argument $arguments): CountryCollection
    {
        $countryCollection = new CountryCollection;

        $map = $this->identityMap->getFromMap($countryCollection, $arguments);

        if ($map !== false) {
            return $map;
        }

        $countriesData = $this->adapter->get($arguments);

        foreach ($countriesData as $country) {
            $countryEntity = $this->getCountryEntity($country);
            $countryCollection->add($countryEntity);
        }

        $this->identityMap->addToMap($countryCollection, $arguments);

        return $countryCollection;
    }

    /**
     * Size of countries data
     *
     * @param Argument $arguments
     *
     * @return int
     */
    public function getCountriesDataCount(Argument $arguments): int
    {
        return $this->adapter->count($arguments);
    }

    /**
     * Convert country data to country entity
     *
     * @param \stdClass|CountryORMModel $country
     *
     * @throw ApiException
     *
     * @return CountryEntity
     *
     */
    private function getCountryEntity($country): CountryEntity
    {
        return (new CountryEntity)
            ->setId($country->cnt_id)
            ->setCode($country->cnt_code)
            ->setTitle($country->cnt_title)
            ->setDateCreate($country->cnt_created)
            ->setDateModify($country->cnt_modify)
        ;
    }
}
