<?php

namespace App\API\V1\Adapters\MySQL;

use App\API\V1\SMSEdge\MySQL\CountryORMModel;
use App\API\V1\Adapters\Interfaces\CountryInterface;
use App\API\V1\Entities\CountryEntity;
use App\API\V1\Classes\Argument\Argument;
use App\API\V1\Classes\Argument\Filter;
use App\Exceptions\ApiException;
use Illuminate\Database\Eloquent\Builder;

/**
 * Adapter MySQL for working with sendLogsAggregated
 *
 * @codeCoverageIgnore
 *
 * @package api
 * @subpackage SMSEdge test
 * @author Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 */
class CountryMySQL extends MySQLAdapter implements CountryInterface
{
    /**
     * @var string sendLogAggregated table name
     */
    protected $countryTableName;

    /**
     * CountryMySQL constructor.
     *
     * @param array $adapterData
     *
     * @throws ApiException
     */
    public function __construct(array $adapterData = [])
    {
        parent::__construct($adapterData);

        $this->dbGroup = $this->adapter['group'];
        $this->countryTableName = (new CountryORMModel())->getTable();
    }

    /**
     * Get link to DB
     *
     * @return CountryORMModel|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder|\stdClass
     */
    protected function getDbCountry(): CountryORMModel
    {
        return (new CountryORMModel)->setConnection($this->getDbGroup());
    }

    /**
     * Get data
     *
     * @param Argument $arguments
     *
     * @throws ApiException
     *
     * @return array
     */
    public function get(Argument $arguments): array
    {
        if (
            !empty($arguments->getFilters()->id) && !empty($arguments->getSorts()->get())
        ) {
            $this->notSupportedException();
        }

        $countries = $this->filters($arguments->getFilters());

        if (empty($arguments->getFilters()->id)) {
            foreach ($arguments->getSorts()->get() as $sort) {
                switch ($sort->column) {
                    case 'username': // sorting by user field
                        break;
                    default:
                        $link = $sort->column;
                }

                $countries->orderBy($link, $sort->dir);
            }

            if (!empty($arguments->getPage()->getSize())) {
                $countries
                    ->limit($arguments->getPage()->getSize())
                    ->offset($arguments->getPage()->getOffset());
            }
        }

        return $countries->get()->all();
    }

    /**
     * Count data in query
     *
     * @param Argument $argument
     *
     * @return int
     */
    public function count(Argument $argument): int
    {
        return parent::count($argument);
    }

    /**
     * Apply filters
     *
     * @param Filter $filters
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function filters(Filter $filters): Builder
    {
        $countryModel = $this->getDbCountry()->newQuery()->select($this->countryTableName . '.*');

        if (isset($filters->id)) {
            $countryModel
                ->where($this->countryTableName . '.cnt_id', '=', $filters->id);
        }

        if (isset($filters->code)) {
            $countryModel
                ->where($this->countryTableName . '.cnt_code', '=', $filters->code);
        }

        if (!empty($filters->search)) {
            $term = str_replace(['_', '%', '"'], ['\_', '\%', '\"'], trim($filters->search));

            $countryModel->where(function ($query) use ($term) {
                $query
                    ->orWhere($this->countryTableName . '.cnt_title', 'LIKE', '%' . $term . '%')
                    ->orWhere($this->countryTableName . '.cnt_code', 'LIKE', '%' . $term . '%')
                ;
            });
        }

        return $countryModel;
    }
}
