<?php

namespace App\API\V1\Classes\Specifications\Jsonapi;

use App\API\V1\Classes\Specifications\Jsonapi\Collections\ErrorCollection;
use App\API\V1\Classes\Specifications\Jsonapi\Collections\ResourceCollection;
use App\API\V1\Classes\Specifications\Jsonapi\Objects\AttributeObject;
use App\API\V1\Classes\Specifications\Jsonapi\Objects\ErrorObject;
use App\API\V1\Classes\Specifications\Jsonapi\Objects\JsonapiObject;
use App\API\V1\Classes\Specifications\Jsonapi\Objects\LinkObject;
use App\API\V1\Classes\Specifications\Jsonapi\Objects\MetaObject;
use App\API\V1\Classes\Specifications\Jsonapi\Objects\SourceObject;
use App\API\V1\Classes\Specifications\Jsonapi\Objects\RelationshipObject;
use App\API\V1\Classes\Specifications\Jsonapi\Objects\ResourceIdentifierObject;
use App\API\V1\Classes\Specifications\Jsonapi\Objects\ResourceObject;

/**
 * Output SpecificationJsonapi class
 *
 * @package  SpecificationJsonapi
 * @subpackage masterzoo masterzoo
 * @author Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 * @filesource
 */
class SpecificationJsonapi
{
    /**
     * MUST contain at least one
     * data: the document's "primary data"
     * The members data and errors MUST NOT coexist in the same document.
     *
     * @see http://jsonapi.org/format/#document-top-level
     * @var array
     */
    private $data = [];

    /**
     * MUST contain at least one
     * errors: an array of error objects
     * The members data and errors MUST NOT coexist in the same document.
     *
     * @see http://jsonapi.org/format/#document-top-level
     * @var array
     */
    private $errors = [];

    /**
     * MUST contain at least one
     * meta: a meta object that contains non-standard meta-information.
     *
     * @see http://jsonapi.org/format/#document-top-level
     * @var array
     */
    private $meta = [];

    /**
     * MAY contain any
     * jsonapi: an object describing the server's implementation
     *
     * @see http://jsonapi.org/format/#document-top-level
     * @var array
     */
    private $jsonApi = [];

    /**
     * MAY contain any
     * links: a links object related to the primary data.
     *
     * @see http://jsonapi.org/format/#document-top-level
     * @var array
     */
    private $links = [];

    /**
     * MAY contain any
     * included: an array of resource objects that are related to the primary data and/or each other ("included resources").
     *
     * @see http://jsonapi.org/format/#document-top-level
     * @var array
     */
    private $included = [];

    /**
     * @return AttributeObject|\stdClass
     */
    public function getAttributeObject(): AttributeObject
    {
        return new AttributeObject;
    }

    /**
     * @return ErrorObject
     */
    public function getErrorObject(): ErrorObject
    {
        return new ErrorObject;
    }

    /**
     * @return JsonapiObject
     */
    public function getJsonapiObject(): JsonapiObject
    {
        return new JsonapiObject;
    }

    /**
     * @return LinkObject|\stdClass
     */
    public function getLinkObject(): LinkObject
    {
        return new LinkObject;
    }

    /**
     * @return MetaObject|\stdClass
     */
    public function getMetaObject(): MetaObject
    {
        return new MetaObject;
    }

    /**
     * @return SourceObject
     */
    public function getSourceObject(): SourceObject
    {
        return new SourceObject;
    }

    /**
     * @return RelationshipObject|\stdClass
     */
    public function getRelationshipObject(): RelationshipObject
    {
        return new RelationshipObject;
    }

    /**
     * @return ResourceIdentifierObject
     */
    public function getResourceIdentifierObject(): ResourceIdentifierObject
    {
        return new ResourceIdentifierObject;
    }

    /**
     * @return ResourceObject
     */
    public function getResourceObject(): ResourceObject
    {
        return new ResourceObject;
    }

    /**
     * Return whole jsonapi object
     *
     * @return array
     */
    public function getApiData(): array
    {
        // MUST be in doc
        $data = !empty($this->data)
            ? ['data' => $this->data]
            : [];

        // MUST be in doc
        $errors = !empty($this->errors)
            ? ['errors' => $this->errors]
            : [];

        // MUST be in doc
        $meta = !empty($this->meta)
            ? ['meta' => $this->meta]
            : [];

        // MAY be in doc
        $jsonApi = !empty($this->jsonApi)
            ? ['jsonapi' => $this->jsonApi]
            : [];

        // MAY be in doc
        $links = !empty($this->links)
            ? ['links' => $this->links]
            : [];

        // MAY be in doc
        $included = !empty($this->included)
            ? ['included' => $this->included]
            : [];

        // The members data and errors MUST NOT coexist in the same document.
        if (!empty($data) && empty($errors)) {
            return array_merge($data, $links, $included, $meta, $jsonApi);
        }

        if (empty($data) && !empty($errors)) {
            return array_merge($errors, $links, $included, $meta, $jsonApi);
        }

        return [];
    }

    /**
     * Set data
     *
     * @param ResourceCollection $resources
     *
     * @return $this
     */
    public function setData(ResourceCollection $resources): self
    {
        $this->data = $this->setResources($resources);

        return $this;
    }

    /**
     * Generates an array for inclusion in the whole response body of an errors collection
     *
     * @see http://jsonapi.org/format/#errors
     *
     * @param array|ErrorCollection|ErrorObject $errors
     *
     * @return $this
     * array, containing:
     *         - id
     *         - links
     *           - about
     *         - status
     *         - code
     *         - title
     *         - detail
     *         - source
     *           - pointer
     *           - parameter
     *         - meta
     */
    public function setErrors(ErrorCollection $errors): self
    {
        $errors = $errors->get();

        $response = [];

        $i = 0;

        /** @var ErrorObject $error */
        foreach ($errors as $error) {
            if ($error->getIdentifier()) {
                $response[$i]['id'] = $error->getIdentifier();
            }

            $linkObjCount = (new \ArrayObject($error->getLink()))->count();

            if ($linkObjCount) {
                $link = $error->getLink();

                if ($link !== null) {
                    $response[$i]['link']['about'] = $link->about;
                }
            }

            if ($error->getHttpStatus()) {
                $response[$i]['status'] = $error->getHttpStatus();
            }

            if ($error->getCode()) {
                $response[$i]['code'] = $error->getCode();
            }

            if ($error->getTitle()) {
                $response[$i]['title'] = $error->getTitle();
            }

            if ($error->getDetail()) {
                $response[$i]['detail'] = $error->getDetail();
            }

            $source = $error->getSource();

            if ($source) {
                if ($source->getPointer()) {
                    $response[$i]['source']['pointer'] = $source->getPointer();
                }

                if ($source->getParameter()) {
                    $response[$i]['source']['parameter'] = $source->getParameter();
                }
            }

            $metaObjCount = (new \ArrayObject($error->getMeta()))->count();

            if ($metaObjCount) {
                $response[$i]['meta'] = $error->getMeta();
            }

            $i++;
        }

        $this->errors = $response;

        return $this;
    }

    /**
     * Meta information
     *
     * @param MetaObject $meta
     * @param bool $propertySave
     *
     * @return MetaObject
     */
    public function setMeta(MetaObject $meta, $propertySave = true): MetaObject
    {
        if ($propertySave && (new \ArrayObject($meta))->count()) {
                $this->meta = $meta;
        }

        return $meta;
    }

    /**
     * Version of implemented specification
     *
     * @param JsonapiObject $jsonapi
     *
     * @return $this
     */
    public function setJsonapi(JsonapiObject $jsonapi): self
    {
        $response = [];

        $response['version'] = $jsonapi->getVersion();

        $metaObjCount = (new \ArrayObject($jsonapi->getMeta()))->count();

        if ($metaObjCount) {
            $response['meta'] = $jsonapi->getMeta();
        }

        $this->jsonApi = $response;

        return $this;
    }

    /**
     * Links
     *
     * @param LinkObject $links
     * @param bool $propertySave
     *
     * @return \stdClass
     */
    public function setLinks(LinkObject $links, $propertySave = true): \stdClass
    {
        $response = new \stdClass;

        $linkObjCount = (new \ArrayObject($links))->count();

        if ($linkObjCount) {
            /**
             * @var string $prop
             * @var LinkObject $link
             */
            foreach ($links as $prop => $link) {
                if (\is_object($link)) {
                    $tmp = new \stdClass;

                    if ($link->getHref()) {
                        $tmp->href = $link->getHref();
                    }

                    $metaObjCount = (new \ArrayObject($link->getMeta()))->count();

                    if ($metaObjCount) {
                        $tmp->meta = $this->setMeta($link->getMeta(), false);
                    }

                    $response->{$prop} = $tmp;
                } else {
                    $response->{$prop} = $link;
                }
            }
        }

        if ($propertySave) {
            $this->links = $response;
        }

        return $response;
    }

    /**
     * @param ResourceCollection $resources
     *
     * @return $this
     */
    public function setIncluded(ResourceCollection $resources): self
    {
        $this->included = $this->setResources($resources);

        return $this;
    }

    /**
     * @param array|ErrorCollection|ErrorObject|ResourceCollection $resources
     *
     * @return array
     */
    private function setResources(ResourceCollection $resources): array
    {
        $resources = $resources->get();

        $response = [];

        $i = 0;

        /** @var ResourceObject $resource */
        foreach ($resources as $resource) {
            if ($resource->getId()) {
                $response[$i]['id'] = $resource->getId();
            }

            if ($resource->getType()) {
                $response[$i]['type'] = $resource->getType();
            }

            $attrObjCount = (new \ArrayObject($resource->getAttribute()))->count();

            if ($attrObjCount) {
                $response[$i]['attributes'] = $resource->getAttribute();
            }

            $relationshipObjCount = (new \ArrayObject($resource->getRelationship()))->count();

            if ($relationshipObjCount) {
                $rel = new \stdClass;

                /**
                 * @var string $prop
                 * @var RelationshipObject $relationship
                 */
                foreach ($resource->getRelationship() as $prop => $relationship) {
                    if (\is_object($relationship)) {
                        $tmp = new \stdClass;

                        $linkObjCount = (new \ArrayObject($relationship->getLink()))->count();

                        if ($linkObjCount) {
                            $tmp->links = $this->setLinks($relationship->getLink(), false);
                        }

                        if ($relationship->getData()) {
                            $tmp->data = \count($relationship->getData()) === 1
                                ? current($this->setResources($relationship->getData()))
                                : $this->setResources($relationship->getData());
                        }

                        $metaObjCount = (new \ArrayObject($relationship->getMeta()))->count();

                        if ($metaObjCount) {
                            $tmp->meta = $this->setMeta($relationship->getMeta(), false);
                        }

                        $rel->{$prop} = $tmp;
                    } else {
                        $rel->{$prop} = $relationship;
                    }
                }

                $response[$i]['relationships'] = $rel;
            }

            $linkObjCount = (new \ArrayObject($resource->getLink()))->count();

            if ($linkObjCount) {
                $response[$i]['links'] = $this->setLinks($resource->getLink(), false);
            }

            $metaObjCount = (new \ArrayObject($resource->getMeta()))->count();

            if ($metaObjCount) {
                $response[$i]['meta'] = $this->setMeta($resource->getMeta(), false);
            }

            $i++;
        }

        return $response;
    }
}