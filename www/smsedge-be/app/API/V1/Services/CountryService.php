<?php

namespace App\API\V1\Services;

use App\API\V1\Classes\Argument\Argument;
use App\API\V1\Mappers\CountryMapper;
use App\API\V1\Entities\CountryEntity;
use App\API\V1\Collections\CountryCollection;
use App\Exceptions\ApiException;
use Dingo\Api\Http\Request;

/**
 * API SMSEdge test
 * Country Service class
 *
 * @package  api
 * @subpackage SMSEdge test
 * @author Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 * @filesource
 */
class CountryService extends ServiceAbstract
{
    /**
     * @var CountryMapper
     */ 
    private $countryMapper;

    /**
     * @var CountryCollection
     */
    protected $data;

    /**
     * Country service constructor.
     *
     * @param Request $request
     * @param Argument $argument
     * @param CountryMapper $countryMapper
     *
     * @throws \LogicException
     */
    public function __construct(Request $request, Argument $argument, CountryMapper $countryMapper)
    {
        $this->request = $request;
        $this->countryMapper = $countryMapper;
        $this->arguments = $argument;
        $this->setArguments();
    }

    /**
     * Get countrys data
     *
     * @throws ApiException|\LogicException
     *
     * @return $this
     */
    public function getCountries(): self
    {
        $this->data = $this->countryMapper->getCountriesData($this->arguments);

        return $this;
    }

    /**
     * Size of countrys data
     *
     * @return int
     */
    public function getCountriesCount(): int
    {
        return $this->countryMapper->getCountriesDataCount($this->arguments);
    }

    /**
     * Set data
     *
     * @param CountryEntity $countryEntity
     *
     * @return $this
     */
    public function setData(CountryEntity $countryEntity): self
    {
        $countryCollection = new CountryCollection;
        $countryCollection->add($countryEntity);

        $this->data = $countryCollection;

        return $this;
    }

    /**
     * Get data
     *
     * @throws ApiException
     *
     * @return CountryCollection
     */
    public function getData(): CountryCollection
    {
        if ($this->data === null || empty($this->data->get())) {
            $this->notFoundException();
        }

        return $this->data;
    }
}
