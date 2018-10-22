<?php

namespace App\API\V1\Adapters\MySQL;

use App\API\V1\Classes\Argument\Argument;
use App\API\V1\Classes\Argument\Filter;
use App\API\V1\Filters\FilterHelper;
use App\Exceptions\ApiException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use \Illuminate\Database\Query\Expression;

/**
 * MySQL Adapter abstract class
 *
 * @codeCoverageIgnore
 *
 * @package api
 * @subpackage SMSEdge test
 * @author Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 * @filesource
 */
abstract class MySQLAdapter
{
    /**
     * @var string
     */
    protected $dbGroup;

    /**
     * @var array
     */
    protected $adapter;

    /**
     * @var FilterHelper
     */
    protected $filterHelper;

    /**
     * MySQLAdapter constructor.
     *
     * @param array $adapterData
     * 
     * @throws ApiException
     */
    public function __construct(array $adapterData = [])
    {
        if (empty($adapterData))
        {
            $storage = config('smsedge')['Storage'];

            if (!isset($storage['MySQL']))
            {
                throw new ApiException(404, __('API configuration of MySQL is absent'));
            }

            $this->adapter = $storage['MySQL'];
        }
        else
        {
            $this->adapter = $adapterData;
        }

        $this->filterHelper = new FilterHelper;
    }

    /**
     * Count data
     *
     * @param Argument $arguments
     *
     * @return int
     */
    public function count(Argument $arguments): int
    {
        $data = $this->filters($arguments->getFilters());

        return $data->count();
    }

    /**
     * Get DB group
     *
     * @return string
     */
    public function getDbGroup(): string
    {
        return $this->dbGroup;
    }

    /**
     * Convert value to null by condition
     * Because in int field, foreign key in MySQL can apply NULL or key on related table
     *
     * @param mixed $value
     *
     * @return int|null
     */
    protected function convertToNull($value)
    {
        return (\is_int($value) && $value === 0)
            ? null
            : $value
        ;
    }

    /**
     * DB connection
     * (wrapper for valid inspection code)
     *
     * @param string $group
     *
     * @return \Illuminate\Database\Connection|\stdClass
     */
    protected function dbConnection($group)
    {
        return DB::connection($group);

    }

    /**
     * DB raw expression
     * (wrapper for valid inspection code)
     *
     * @param string $expression
     *
     * @return Expression
     */
    protected function dbRaw($expression): Expression
    {
        return DB::raw($expression);
    }

    /**
     * Not supported excepton
     * (wrapper for valid inspection code)
     *
     * @throws ApiException
     *
     * @return void
     */
    protected function notSupportedException()
    {
        $apiException = new ApiException(400, __('Sort not supported'));
        $apiException->detail_message = __('The action is not supported in the request');

        throw $apiException;
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
    protected function cannotBeDeletedException()
    {
        $apiException = new ApiException(409, __('Record deletion'));
        $apiException->detail_message = __('The record can not be deleted. This record is used in another part of the site');

        throw $apiException;
    }

    /**
     * Create filters for query
     *
     * @param Filter $filters
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    abstract protected function filters(Filter $filters): Builder;
}
