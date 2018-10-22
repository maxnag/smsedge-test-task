<?php

namespace App\API\V1\Entities;

use App\API\V1\Classes\LazyLoader;

/**
 * Entity for sendLogAggregated
 *
 * @package  api
 * @subpackage SMSEdge test
 * @author Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 * @filesource
 */
class SendLogAggregatedEntity extends CommonEntity implements InterfaceEntity
{
    // properties of own entity
    protected $date = '';
    protected $usrId = 0;
    protected $usrName = '';
    protected $cntCode = '';
    protected $cntTitle = '';
    protected $success = 0;
    protected $fail = 0;

    // properties of related entity
    private $lazyLoadedAuthor;
    private $lazyLoadedCountry;

    /**
     * Get date
     *
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * Set date
     *
     * @param string $date
     *
     * @return $this
     */
    public function setDate($date): self
    {
        $this->date = (string)$date;

        return $this;
    }

    /**
     * Get user ID
     *
     * @return int
     */
    public function getUsrId(): int
    {
        return $this->usrId;
    }

    /**
     * Set user ID
     *
     * @param int $usrId
     *
     * @return $this
     */
    public function setUsrId($usrId): self
    {
        $this->usrId = (int)$usrId;

        return $this;
    }

    /**
     * Get user name
     *
     * @return string
     */
    public function getUsrName(): string
    {
        return $this->usrName;
    }

    /**
     * Set user ID
     *
     * @param string $usrId
     *
     * @return $this
     */
    public function setUsrName($usrId): self
    {
        $this->usrName = (string)$usrId;

        return $this;
    }

    /**
     * Get  ID
     *
     * @return string
     */
    public function getCntCode(): string
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
    public function setCntCode($cntCode): self
    {
        $this->cntCode = (string)$cntCode;

        return $this;
    }

    /**
     * Get country data
     *
     * @return string
     */
    public function getCntTitle(): string
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
    public function setCntTitle($cntTitle): self
    {
        $this->cntTitle = (string)$cntTitle;

        return $this;
    }

    /**
     * Get success
     *
     * @return int
     */
    public function getSuccess(): int
    {
        return $this->success;
    }

    /**
     * Set success
     *
     * @param int $success
     *
     * @return $this
     */
    public function setSuccess($success): self
    {
        $this->success = (int)$success;

        return $this;
    }

    /**
     * Get fail
     *
     * @return int
     */
    public function getFail(): int
    {
        return $this->fail;
    }

    /**
     * Set fail
     *
     * @param int $fail
     *
     * @return $this
     */
    public function setFail($fail): self
    {
        $this->fail = (int)$fail;

        return $this;
    }

// ---------------------------------------------------------------------------------------------------------------------

    /**
     * Get author data
     *
     * @return UserEntity
     */
    public function getAuthor(): UserEntity
    {
        return \is_callable($this->lazyLoadedAuthor)
            ? \call_user_func($this->lazyLoadedAuthor)
            : new UserEntity;
    }

    /**
     * Set author data mapper
     *
     * @param \Closure $callback
     *
     * @return $this
     */
    public function setAuthor($callback): self
    {
        $this->lazyLoadedAuthor = new LazyLoader($callback);

        return $this;
    }

    /**
     * Get region data
     *
     * @return CountryEntity
     */
    public function getCountry(): CountryEntity
    {
        return \is_callable($this->lazyLoadedCountry)
            ? \call_user_func($this->lazyLoadedCountry)
            : new CountryEntity;
    }

    /**
     * Set author data mapper
     *
     * @param \Closure $callback
     *
     * @return $this
     */
    public function setCountry($callback): self
    {
        $this->lazyLoadedCountry = new LazyLoader($callback);

        return $this;
    }

// ---------------------------------------------------------------------------------------------------------------------
}
