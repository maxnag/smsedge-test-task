<?php

namespace App\API\V1\Entities;

/**
 * Entity interface class
 *
 * @package  api
 * @subpackage SMSEdge test
 * @author Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 * @filesource
 */
interface InterfaceEntity
{
    /**
     * Get entity ID
     *
     * @return int|string
     */
    public function getId();

    /**
     * Set entity ID
     *
     * @param int $id
     *
     * @return mixed
     */
    public function setId($id);

    /**
     * Get create date
     *
     * @return string
     */
    public function getDateCreate(): string;

    /**
     * Set create date
     *
     * @param string $date
     *
     * @return mixed
     */
    public function setDateCreate($date);

    /**
     * Get modify date
     *
     * @return string
     */
    public function getDateModify(): string;

    /**
     * Set modify date
     *
     * @param string $date
     *
     * @return mixed
     */
    public function setDateModify($date);

    /**
     * Converting property of object into array
     *
     * @param array $expected
     *
     * @return array
     */
    public function getArray(array $expected = []): array;
}
