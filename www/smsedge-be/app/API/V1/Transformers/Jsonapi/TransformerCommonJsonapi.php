<?php

namespace App\API\V1\Transformers\Jsonapi;

use App\API\V1\Classes\Argument\Sort;
use App\API\V1\Classes\Specifications\Jsonapi\Collections\ErrorCollection;
use App\API\V1\Classes\Specifications\Jsonapi\Collections\ResourceCollection;
use App\API\V1\Classes\Specifications\Jsonapi\Objects\LinkObject;
use App\API\V1\Classes\Specifications\Jsonapi\Objects\MetaObject;
use App\API\V1\Classes\Specifications\Jsonapi\SpecificationJsonapi;
use App\API\V1\Transformers\TransformerData;
use App\API\V1\Transformers\TransformerInterface;

/**
 * API SMSEdge test
 * Common class for JsonAPI converter data classes
 *
 * @package  api
 * @subpackage SMSEdge test
 * @author Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 * @filesource
 */
class TransformerCommonJsonapi implements TransformerInterface
{
    /**
     * @var LinkObject
     */
    protected $pager;

    /**
     * @var MetaObject
     */
    protected $meta;

    /**
     * @var SpecificationJsonapi
     */
    protected $specification;

    /**
     * TransformerCommonJsonapi constructor.
     *
     * @param SpecificationJsonapi $specification
     */
    public function __construct(SpecificationJsonapi $specification)
    {
        $this->specification = $specification;
    }

    /**
     * Get transformed data
     *
     * @param TransformerData $data
     *
     * @return array
     */
    public function getTransformedData(TransformerData $data): array
    {
        return [];
    }

    /**
     * Get errors data
     *
     * @param TransformerData $data
     *
     * @throws \Exception
     *
     * @return array
     */
    public function getErrorsData(TransformerData $data): array
    {
        if (empty($data->getErrors())) {
            return [];
        }

        $errorCollection = $this->getErrorCollection();

        foreach ($data->getErrors() as $attr => $errors) {
            /** @var $errors array */
            foreach ($errors as $key => $error) {
                $link = $this->specification->getLinkObject();
                $link->about = $data->getRequest()->root() . $data->getRequest()->getRequestUri();

                $sourceEntity = $this->specification->getSourceObject()
                    ->setParameter($attr)
                    ->setPointer('/data/attribute/' . $attr);

                $errorEntity = $this->specification->getErrorObject()
                    ->setTitle(__('The value of attribute :attr is wrong', ['attr' => $attr]))
                    ->setDetail($error)
                    ->setHttpStatus('')// TODO: for feature
                    ->setCode('')// TODO: for feature
                    ->setSource($sourceEntity)
                    ->setLink($link);

                $errorEntity->setIdentifier($errorEntity->getIdentifier() . '-' . $attr . '-' . $key);
                $errorCollection->add($errorEntity);
            }
        }

        $apiDataOutput = $this->specification
            ->setErrors($errorCollection)
            ->setJsonapi($this->specification->getJsonapiObject());

        $apiDataOutput->setMeta($this->getMeta($data));

        return $apiDataOutput->getApiData();
    }

    /**
     * Get meta information object
     *
     * @param TransformerData $data
     *
     * @return MetaObject
     */
    public function getMeta(TransformerData $data): MetaObject
    {
        $metaObj = $this->specification->getMetaObject();
        $metaObj->{'api-version'} = $data->getApiVersion();
        $metaObj->copyright = 'Max Nagaychenko (http://blog.nagaychenko.com)';

        if (!empty($data->getDataCount())) {
            $metaObj->{'entity-count'} = $data->getDataCount();
        }

        return $metaObj;
    }

    /**
     * Get pagers links data
     *
     * @param TransformerData $data
     *
     * @return LinkObject
     */
    public function getPager(TransformerData $data): LinkObject
    {
        $linkObj = $this->specification->getLinkObject();

        if (!empty($data->getArguments()->getPage()->getSize())) {
            $linkObj->self = $data->getApiUrl(false);

//----------------------------------------------------------------------------------------------------------------------
            $sorts = $data->getArguments()->getSorts()->get();
            $sort = !empty($sorts)
                ? '&sort='
                : '';

            foreach ($sorts as $s) {
                $dir = $s->dir === Sort::DESC
                    ? '-'
                    : '';
                $sort .= $dir . $s->column . ',';
            }

            $sort = trim($sort, ',');
//----------------------------------------------------------------------------------------------------------------------
            $filters = $data->getArguments()->getFilters();
            $filter = '';

            foreach ($filters as $key => $value) {
                if (empty($value)) {
                    continue;
                }

                $filter .= '&filter[' . $key . ']=' . $value;
            }

            $filter = trim($filter, '&');
//----------------------------------------------------------------------------------------------------------------------
            $pageSize = $data->getArguments()->getPage()->getSize();
            $currentPageNumber = $data->getArguments()->getPage()->getPage();

            $prev = (($currentPageNumber - 1) <= 0)
                ? 1
                : ($currentPageNumber - 1);

            $maxPage = ceil($data->getDataCount() / $pageSize);
            $next = ($currentPageNumber + 1) > $maxPage
                ? $currentPageNumber
                : ($currentPageNumber + 1);
//----------------------------------------------------------------------------------------------------------------------
            $query = rtrim(implode('&', [$sort, $filter]), '&');

            $linkObj->first = $data->getApiUrl(false) . '?page[number]=1&page[size]=' . $pageSize . $query;
            $linkObj->last = $data->getApiUrl(false) . '?page[number]=' . $maxPage . '&page[size]=' . $pageSize . $query;
            $linkObj->prev = $data->getApiUrl(false) . '?page[number]=' . $prev . '&page[size]=' . $pageSize . $query;
            $linkObj->next = $data->getApiUrl(false) . '?page[number]=' . $next . '&page[size]=' . $pageSize . $query;
        }

        return $linkObj;
    }

    /**
     * Convert value to null by condition
     * Because in int field, foreign key in MySQL can apply NULL or key on related table
     *
     * @param mixed $value
     *
     * @return int|null
     */
    protected function convertToNull($value)
    {
        return (\is_int($value) && $value === 0)
            ? null
            : $value
        ;
    }

    /**
     * @return ErrorCollection
     */
    protected function getErrorCollection(): ErrorCollection
    {
        return new ErrorCollection;
    }

    /**
     * @return ResourceCollection
     */
    protected function getResourceCollection(): ResourceCollection
    {
        return new ResourceCollection;
    }
}
