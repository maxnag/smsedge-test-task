<?php

namespace App\API\V1\Adapters\MySQL;

use App\API\V1\SMSEdge\MySQL\UserORMModel;
use App\API\V1\Adapters\Interfaces\UserInterface;
use App\API\V1\Entities\UserEntity;
use App\API\V1\Classes\Argument\Argument;
use App\API\V1\Classes\Argument\Filter;
use App\Exceptions\ApiException;
use Illuminate\Database\Eloquent\Builder;

/**
 * Adapter MySQL for working with user
 *
 * @codeCoverageIgnore
 *
 * @package api
 * @subpackage SMSEdge test
 * @author Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 */
class UserMySQL extends MySQLAdapter implements UserInterface
{
    /**
     * @var string sendLogAggregated table name
     */
    protected $userTableName;

    /**
     * UserMySQL constructor.
     *
     * @param array $adapterData
     *
     * @throws ApiException
     */
    public function __construct(array $adapterData = [])
    {
        parent::__construct($adapterData);

        $this->dbGroup = $this->adapter['group'];
        $this->userTableName = (new UserORMModel())->getTable();
    }

    /**
     * Get link to DB
     *
     * @return UserORMModel|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder|\stdClass
     */
    protected function getDbUser(): UserORMModel
    {
        return (new UserORMModel)->setConnection($this->getDbGroup());
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

        $users = $this->filters($arguments->getFilters());

        if (empty($arguments->getFilters()->id)) {
            foreach ($arguments->getSorts()->get() as $sort) {
                switch ($sort->column) {
                    case 'username': // sorting by user field
                        break;
                    default:
                        $link = $sort->column;
                }

                $users->orderBy($link, $sort->dir);
            }

            if (!empty($arguments->getPage()->getSize())) {
                $users
                    ->limit($arguments->getPage()->getSize())
                    ->offset($arguments->getPage()->getOffset());
            }
        }

        return $users->get()->all();
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
        $userModel = $this->getDbUser()->newQuery()->select($this->userTableName . '.*');

        if (isset($filters->id)) {
            $userModel
                ->where($this->userTableName . '.usr_id', '=', $filters->id);
        }

        if (!empty($filters->search)) {
            $userModel
                ->where($this->userTableName . '.usr_name', 'LIKE', str_replace(['_', '%', '?'], ['\_', '\%', '\?'], $filters->search) . '%');
        }

        return $userModel;
    }
}
