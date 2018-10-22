<?php

namespace App\API\V1\Transformers\Jsonapi;

use App\API\V1\Collections\CountryCollection;
use App\API\V1\Entities\CountryEntity;
use App\API\V1\Transformers\TransformerData;

/**
 * API SMSEdge test
 * Strategy JsonAPI class for country transformer data class
 *
 * @package  api
 * @subpackage SMSEdge test
 * @author Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 * @filesource
 */
class CountryJsonapi extends TransformerCommonJsonapi
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

        /** @var CountryCollection $countries */
        $countries = $data->getData();

        /** @var CountryEntity $country */
        foreach ($countries as $country) {
            $resAttrObj = $this->specification->getAttributeObject();
            $resAttrObj->cnt_id = $this->convertToNull($country->getId());
            $resAttrObj->cnt_code = $country->getCode();
            $resAttrObj->cnt_title = $country->getTitle();
            $resAttrObj->cnt_created = $country->getDateCreate();
            $resAttrObj->cnt_modify = $country->getDateModify();
//---------------------------------------------------------------------------------------------------------------------

//----------------------------------------------------------------------------------------------------------------------
            $resLinkObj = $this->specification->getLinkObject();
            $resLinkObj->self = $data->getApiUrl() . 'country/' . $country->getId();
//----------------------------------------------------------------------------------------------------------------------
            $resourceObj = $this->specification->getResourceObject()
                ->setId($country->getId())
                ->setType('country')
                ->setAttribute($resAttrObj)
                ->setLink($resLinkObj);

            $resourceObjCollection->add($resourceObj);
//----------------------------------------------------------------------------------------------------------------------
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
