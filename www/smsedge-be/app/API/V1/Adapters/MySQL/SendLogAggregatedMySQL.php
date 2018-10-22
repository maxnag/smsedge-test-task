<?php

namespace App\API\V1\Adapters\MySQL;

use App\API\V1\SMSEdge\MySQL\SendLogAggregatedORMModel;
use App\API\V1\Adapters\Interfaces\SendLogAggregatedInterface;
use App\API\V1\Entities\SendLogAggregatedEntity;
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
class SendLogAggregatedMySQL extends MySQLAdapter implements SendLogAggregatedInterface
{
    /**
     * @var string sendLogAggregated table name
     */
    protected $sendLogAggregatedTableName;

    /**
     * SendLogAggregatedMySQL constructor.
     *
     * @param array $adapterData
     *
     * @throws ApiException
     */
    public function __construct(array $adapterData = [])
    {
        parent::__construct($adapterData);

        $this->dbGroup = $this->adapter['group'];
        $this->sendLogAggregatedTableName = (new SendLogAggregatedORMModel)->getTable();
    }

    /**
     * Get link to DB
     *
     * @return SendLogAggregatedORMModel|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder|\stdClass
     */
    protected function getDbSendLogAggregated(): SendLogAggregatedORMModel
    {
        return (new SendLogAggregatedORMModel)->setConnection($this->getDbGroup());
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

        $sendLogsAggregated = $this->filters($arguments->getFilters());

        if (empty($arguments->getFilters()->id)) {
            foreach ($arguments->getSorts()->get() as $sort) {
                switch ($sort->column) {
                    case 'username': // sorting by user field
                        break;
                    default:
                        $link = $sort->column;
                }

                $sendLogsAggregated->orderBy($link, $sort->dir);
            }

            if (!empty($arguments->getPage()->getSize())) {
                $sendLogsAggregated
                    ->limit($arguments->getPage()->getSize())
                    ->offset($arguments->getPage()->getOffset());
            }
        }

        return $sendLogsAggregated->get()->all();
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
        $sendLogAggregatedModel = $this->getDbSendLogAggregated()->newQuery()->select($this->sendLogAggregatedTableName . '.*');

        if (isset($filters->id)) {
            $sendLogAggregatedModel
                ->where($this->sendLogAggregatedTableName . '.id', '=', $filters->id);
        }

        if (!empty($filters->usr_id)) {
            $sendLogAggregatedModel
                ->where($this->sendLogAggregatedTableName . '.usr_id', '=', $filters->usr_id);
        }

        if (!empty($filters->cnt_code)) {
            $sendLogAggregatedModel
                ->where($this->sendLogAggregatedTableName . '.cnt_code', '=', $filters->cnt_code);
        }

        if (!empty($filters->date_from)) {
            $sendLogAggregatedModel
                ->where($this->sendLogAggregatedTableName . '.date', '>=', $filters->date_from);
        }


        if (!empty($filters->date_to)) {
            $sendLogAggregatedModel
                ->where($this->sendLogAggregatedTableName . '.date', '<=', $filters->date_to);
        }

        return $sendLogAggregatedModel;
    }
}
