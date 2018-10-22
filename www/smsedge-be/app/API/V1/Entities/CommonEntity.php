<?php

namespace App\API\V1\Entities;

/**
 * Entity for events
 *
 * @package  api
 * @subpackage SMSEdge test
 * @author Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 * @filesource
 */
class CommonEntity
{
    protected $id = 0;
    protected $dateCreate = '';
    protected $dateModify = '';

    /**
     * Get ID
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
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
        $this->id = (int)$id;

        return $this;
    }

    /**
     * Get create date
     *
     * @return string
     */
    public function getDateCreate(): string
    {
        return $this->dateCreate;
    }

    /**
     * Set create date
     *
     * @param string $date
     *
     * @return $this
     */
    public function setDateCreate($date): self
    {
        $this->dateCreate = (string)$date;

        return $this;
    }

    /**
     * Get modify date
     *
     * @return string
     */
    public function getDateModify(): string
    {
        return $this->dateModify;
    }

    /**
     * Set modify date
     *
     * @param string $date
     *
     * @return $this
     */
    public function setDateModify($date): self
    {
        $this->dateModify = (string)$date;

        return $this;
    }

    /**
     * Converting property of object into array
     *
     * @param array $expected
     *
     * @return array
     */
    public function getArray(array $expected = []): array
    {
        $data = [];

        foreach ($this as $property => $value) {
            $property = strtolower(preg_replace(['/([a-z\d])([A-Z])/', '/([^_])([A-Z][a-z])/'], '$1_$2', $property));

            if (empty($expected) || \in_array($property, $expected, false)) {
                if (!\is_object($value)) {
                    $data[$property] = $value;
                } else {
                    // @codeCoverageIgnoreStart
                    if (method_exists($value, 'getArray')) {
                        $data[$property] = $value->getArray();
                    }
                    // @codeCoverageIgnoreEnd
                }
            }
        }

        return $data;
    }
}
