<?php

namespace App\API\V1\Transformers\Jsonapi;

use App\API\V1\Collections\SendLogAggregatedCollection;
use App\API\V1\Entities\SendLogAggregatedEntity;
use App\API\V1\Transformers\TransformerData;

/**
 * API SMSEdge test
 * Strategy JsonAPI class for log transformer data class
 *
 * @package  api
 * @subpackage SMSEdge test
 * @author Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 * @filesource
 */
class SendLogAggregatedJsonapi extends TransformerCommonJsonapi
{
    /**
     * Get transformed data
     *
     * @param TransformerData $data
     *
     * @return array
     */
    public function getTransformedData(TransformerData $data): array
    {
        $resourceObjCollection = $this->getResourceCollection();
        $includeObjCollection = $this->getResourceCollection();

        /** @var SendLogAggregatedCollection $logs */
        $logs = $data->getData();

        /** @var SendLogAggregatedEntity $log */
        foreach ($logs as $log) {
            $resAttrObj = $this->specification->getAttributeObject();
            $resAttrObj->date = $log->getDate();
            $resAttrObj->usr_id = $this->convertToNull($log->getId());
            $resAttrObj->usr_name = $log->getUsrName();
            $resAttrObj->cnt_code = $log->getCntCode();
            $resAttrObj->cnt_title = $log->getCntTitle();
            $resAttrObj->success = $log->getSuccess();
            $resAttrObj->fail = $log->getFail();
//---------------------------------------------------------------------------------------------------------------------
            $resRelObj = $this->specification->getRelationshipObject();

            if (!empty($log->getId())) {
                $resRelAuthorObjCollection = $this->getResourceCollection();

                $resAuthorObj = $this->specification->getResourceObject()
                    ->setId($log->getId())
                    ->setType('author');

                $resRelAuthorObjCollection->add($resAuthorObj);

                $resRelAuthorObj = $this->specification->getRelationshipObject()->setData($resRelAuthorObjCollection);
                $resRelObj->author = $resRelAuthorObj;
            }

            if (!empty($log->getCntCode())) {
                $resRelRegionObjCollection = $this->getResourceCollection();

                $resRegionObj = $this->specification->getResourceObject()
                    ->setId($log->getCountry()->getId())
                    ->setType('country');

                $resRelRegionObjCollection->add($resRegionObj);

                $resRelRegionObj = $this->specification->getRelationshipObject()->setData($resRelRegionObjCollection);
                $resRelObj->country = $resRelRegionObj;
            }

//----------------------------------------------------------------------------------------------------------------------
            $resLinkObj = $this->specification->getLinkObject();
            $resLinkObj->self = $data->getApiUrl() . 'log/' . $log->getId();
//----------------------------------------------------------------------------------------------------------------------
            $resourceObj = $this->specification->getResourceObject()
                ->setId($log->getId())
                ->setType('log')
                ->setAttribute($resAttrObj)
                ->setRelationship($resRelObj)
                ->setLink($resLinkObj);

            $resourceObjCollection->add($resourceObj);

//----------------------------------------------------------------------------------------------------------------------

            if (!empty($log->getId())) {
                $includeAttrObj = $this->specification->getAttributeObject();
                $includeAttrObj->author = trim($log->getAuthor()->getName());

                $includeLinkObj = $this->specification->getLinkObject();
                $includeLinkObj->self = $data->getApiUrl() . 'user/' . $log->getAuthor()->getId();

                $includeObj = $this->specification->getResourceObject()
                    ->setId($log->getAuthor()->getId())
                    ->setType('author')
                    ->setAttribute($includeAttrObj)
                    ->setLink($includeLinkObj);

                $includeObjCollection->add($includeObj);
            }

            if (!empty($log->getCntCode())) {
                $includeAttrObj = $this->specification->getAttributeObject();
                $includeAttrObj->country = trim($log->getCountry()->getTitle());

                $includeLinkObj = $this->specification->getLinkObject();
                $includeLinkObj->self = $data->getApiUrl() . 'country/' . $log->getCountry()->getId();

                $includeObj = $this->specification->getResourceObject()
                    ->setId($log->getCountry()->getId())
                    ->setType('country')
                    ->setAttribute($includeAttrObj)
                    ->setLink($includeLinkObj);

                $includeObjCollection->add($includeObj);
            }

            $includeObjCollection->add($includeObj);
        }

        $apiDataOutput = $this->specification
            ->setData($resourceObjCollection)
            ->setIncluded($includeObjCollection)
            ->setJsonapi($this->specification->getJsonapiObject());

        $apiDataOutput->setLinks($this->getPager($data), $data->getDataCount() !== 1);
        $apiDataOutput->setMeta($this->getMeta($data));

        return $apiDataOutput->getApiData();
    }
}
