<?php

namespace App\API\V1\Classes\Specifications\Jsonapi\Objects;

/**
 * Entity for resource
 *
 * @package  json-api
 * @subpackage masterzoo masterzoo
 * @see http://jsonapi.org/format/#document-resource-objects (Resource Objects Information)
 * @author Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 * @filesource
 */
class ResourceObject
{
    private $id = '';
    private $type = '';
    private $attribute;
    private $relationship;
    private $link;
    private $meta;

    /**
     * Get id
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Set id
     *
     * @param string $id
     *
     * @return $this
     */
    public function setId($id): self
    {
        $this->id = (string)$id;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return $this
     */
    public function setType($type): self
    {
        $this->type = (string)$type;

        return $this;
    }

    /**
     * Get attribute entity
     *
     * @return null|AttributeObject
     */
    public function getAttribute()
    {
        return $this->attribute ?? new AttributeObject;
    }

    /**
     * Set attribute entity
     *
     * @param AttributeObject $attribute
     *
     * @return $this
     */
    public function setAttribute(AttributeObject $attribute): self
    {
        $this->attribute = $attribute;

        return $this;
    }

    /**
     * Get relationship entity
     *
     * @return RelationshipObject
     */
    public function getRelationship(): RelationshipObject
    {
        return $this->relationship ?? new RelationshipObject;
    }

    /**
     * Set relationship entity
     *
     * @param RelationshipObject $relationship
     *
     * @return $this
     */
    public function setRelationship(RelationshipObject $relationship): self
    {
        $this->relationship = $relationship;

        return $this;
    }

    /**
     * Get link entity
     *
     * @return null|LinkObject
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
