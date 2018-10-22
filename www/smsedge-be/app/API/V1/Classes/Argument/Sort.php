<?php

namespace App\API\V1\Classes\Argument;

/**
 * API masterzoo masterzoo
 * Sort class
 *
 * @package core
 * @subpackage masterzoo masterzoo
 * @author Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 * @filesource
 */
class Sort
{
    const ASC = 'ASC';
    const DESC = 'DESC';

    /**
     * @var array
     */
    private $sort = [];

    /**
     * @var Collection
     */
    private $collection;

    /**
     * Sort constructor.
     *
     * @param Collection $collection
     */
    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
    }

    /**
     * Get data of sort
     *
     * @return array
     */
    public function get(): array
    {
        return $this->sort;
    }

    /**
     * Set data of sort
     *
     * @param string|array $sort
     *
     * @return $this
     */
    public function set($sort = ''): self
    {
        if (empty($sort)) {
            return $this;
        }

        $tmp = explode(',', $sort);

        if (\is_array($tmp)) {
            foreach ($tmp as $column) {
                if (empty($column)) {
                    continue;
                }

                $this->prepareSort($column);
            }
        }

        $this->sort = $this->collection->get();

        return $this;
    }

    /**
     * Prepare sort object
     *
     * @param $column
     */
    private function prepareSort($column)
    {
        $data = new \stdClass;
        $data->column = trim($column, '- '); //space symbol in quotes is not misprint

        $data->dir = $column[0] === '-'
            ? self::DESC
            : self::ASC;

        $this->collection->add($data);
    }
}
