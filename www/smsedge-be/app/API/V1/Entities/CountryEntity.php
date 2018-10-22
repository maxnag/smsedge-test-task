<?php

namespace App\API\V1\Entities;

/**
 * Entity for country
 *
 * @package  api
 * @subpackage SMSEdge test
 * @author Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 * @filesource
 */
class CountryEntity extends CommonEntity implements InterfaceEntity
{
    // properties of own entity
    protected $cntId = 0;
    protected $cntCode = '';
    protected $cntTitle = '';

    // properties of related entity

    /**
     * Get ID
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->cntId;
    }

    /**
     * Set ID
     *
     * @param int $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->cntId = (int)$id;
        $this->id = $this->cntId;

        return $this;
    }

    /**
     * Get country code
     *
     * @return string
     */
    public function getCode(): string
    {
        return $this->cntCode;
    }

    /**
     * Set country ID
     *
     * @param string $cntCode
     *
     * @return $this
     */
    public function setCode($cntCode): self
    {
        $this->cntCode = (string)$cntCode;

        return $this;
    }

    /**
     * Get country data
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->cntTitle;
    }

    /**
     * Set country data
     *
     * @param string $cntTitle
     *
     * @return $this
     */
    public function setTitle($cntTitle): self
    {
        $this->cntTitle = (string)$cntTitle;

        return $this;
    }

// ---------------------------------------------------------------------------------------------------------------------


// ---------------------------------------------------------------------------------------------------------------------
}
