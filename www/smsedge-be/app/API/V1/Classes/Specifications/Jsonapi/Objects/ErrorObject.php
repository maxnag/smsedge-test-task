<?php

namespace App\API\V1\Classes\Specifications\Jsonapi\Objects;

/**
 * Error object
 *
 * @package json-api
 * @subpackage masterzoo masterzoo
 * @see http://jsonapi.org/format/#errors (errors description)
 * @author Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 * @filesource
 */
class ErrorObject
{
    private $identifier;
    private $link;
    private $status = '';
    private $code = '';
    private $title = '';
    private $detail = '';
    private $source;
    private $meta;

    /**
     * Get identifier
     *
     * @throws \Exception
     *
     * @return string
     */
    public function getIdentifier(): string
    {
        if ($this->identifier === null) {
            $id = substr(md5(
                $this->getLink()->about ?? time() . \random_int(1, 10) . uniqid(true, true)
            ), 0, 5);
        } else {
            $id = $this->identifier;
        }

        return (string)$id;
    }

    /**
     * Set identifier
     *
     * @param string $identifier
     *
     * @return $this
     */
    public function setIdentifier($identifier): self
    {
        $this->identifier = $identifier;

        return $this;
    }

    /**
     * Get link entity
     *
     * @return null|LinkObject|\stdClass
     */
    public function getLink()
    {
        return $this->link ?? new LinkObject;
    }

    /**
     * Set link entity
     *
     * @param LinkObject $link
     *
     * @return $this
     */
    public function setLink(LinkObject $link): self
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get http status
     *
     * @return string
     */
    public function getHttpStatus(): string
    {
        return $this->status;
    }

    /**
     * Set http status
     *
     * @param string $httpStatus
     *
     * @return $this
     */
    public function setHttpStatus($httpStatus): self
    {
        $this->status = (string)$httpStatus;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * Set code
     *
     * @param string $code
     *
     * @return $this
     */
    public function setCode($code): self
    {
        $this->code = (string)$code;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return $this
     */
    public function setTitle($title): self
    {
        $this->title = (string)$title;

        return $this;
    }

    /**
     * Get detail
     *
     * @return string
     */
    public function getDetail(): string
    {
        return $this->detail;
    }

    /**
     * Set detail
     *
     * @param string $detail
     *
     * @return $this
     */
    public function setDetail($detail): self
    {
        $this->detail = (string)$detail;

        return $this;
    }

    /**
     * Get source entity
     *
     * @return null|SourceObject
     */
    public function getSource()
    {
        return $this->source ?? new SourceObject;
    }

    /**
     * Set source entity
     *
     * @param SourceObject $source
     *
     * @return $this
     */
    public function setSource(SourceObject $source): self
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Get meta object
     *
     * @return null|MetaObject
     */
    public function getMeta()
    {
        return $this->meta ?? new MetaObject;
    }

    /**
     * Set meta object
     *
     * @param MetaObject $meta
     *
     * @return $this
     */
    public function setMeta(MetaObject $meta): self
    {
        $this->meta = $meta;

        return $this;
    }
}
