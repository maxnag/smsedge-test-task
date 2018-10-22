<?php

namespace App\API\V1\Transformers\Jsonapi;

use App\API\V1\Collections\UserCollection;
use App\API\V1\Entities\UserEntity;
use App\API\V1\Transformers\TransformerData;

/**
 * API SMSEdge test
 * Strategy JsonAPI class for User transformer data class
 *
 * @package  api
 * @subpackage SMSEdge test
 * @author Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 * @filesource
 */
class UserJsonapi extends TransformerCommonJsonapi
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

        /** @var UserCollection $users */
        $users = $data->getData();

        /** @var UserEntity $user */
        foreach ($users as $user) {
            $resAttrObj = $this->specification->getAttributeObject();
            $resAttrObj->usr_id = $this->convertToNull($user->getId());
            $resAttrObj->usr_name = $user->getName();
            $resAttrObj->usr_active = $user->getActive();
            $resAttrObj->usr_created = $user->getDateCreate();
            $resAttrObj->usr_modify = $user->getDateModify();
//---------------------------------------------------------------------------------------------------------------------

//----------------------------------------------------------------------------------------------------------------------
            $resLinkObj = $this->specification->getLinkObject();
            $resLinkObj->self = $data->getApiUrl() . 'user/' . $user->getId();
//----------------------------------------------------------------------------------------------------------------------
            $resourceObj = $this->specification->getResourceObject()
                ->setId($user->getId())
                ->setType('user')
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
