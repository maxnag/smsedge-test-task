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
class UserEntity extends CommonEntity implements InterfaceEntity
{
    // properties of own entity
    protected $usrId = 0;
    protected $usrName = '';
    protected $usrActive = 1;

    // properties of related entity

    /**
     * Get ID
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->usrId;
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
        $this->usrId = (int)$id;
        $this->id = $this->usrId;

        return $this;
    }

    /**
     * Get  ID
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->usrName;
    }
    
    /**
     * Set country ID
     *
     * @param string $usrName
     *
     * @return $this
     */
    public function setName($usrName): self
    {
        $this->usrName = (string)$usrName;

        return $this;
    }

    /**
     * Get usrActive
     *
     * @return int
     */
    public function getActive(): int
    {
        return $this->usrActive;
    }

    /**
     * Set usrActive
     *
     * @param int $usrActive
     *
     * @return $this
     */
    public function setActive($usrActive): self
    {
        $this->usrActive = (int)$usrActive;

        return $this;
    }

// ---------------------------------------------------------------------------------------------------------------------


// ---------------------------------------------------------------------------------------------------------------------
}
