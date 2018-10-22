<?php

namespace App\API\V1\Transformers\Jsonapi;

use App\API\V1\Transformers\TransformerData;

/**
 * ExceptionJsonapi class
 *
 * @package  ExceptionJsonapi
 * @subpackage SMSEdge test
 * @author Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 * @filesource
 */
class ExceptionJsonapi extends TransformerCommonJsonapi
{
    /**
     * Get errors data
     *
     * @param TransformerData $data
     *
     * @return array
     */
    public function getErrorsData(TransformerData $data): array
    {
        $error = $this->specification->getErrorObject();

        if (!empty($data->getApiUrl())) {
            $link = $this->specification->getLinkObject();
            $link->about = $data->getRequest()->root() . $data->getRequest()->getRequestUri();

            $error->setLink($link);
        }

        if (!empty($data->getData()->source)) {
            $source = $this->specification->getSourceObject()
                ->setPointer($data->getData()->source)
            ;
            $error->setSource($source);
        }

        if (!empty($data->getData()->detail_message)) {
            $error->setDetail($data->getData()->detail_message);
        }

        $error
            ->setHttpStatus($data->getData()->getStatusCode())
            ->setCode($data->getData()->getCode())
            ->setTitle($data->getData()->getMessage());

        $errorCollection = $this->getErrorCollection()
            ->add($error);

        $this->specification->setErrors($errorCollection);
        $this->specification->setMeta($this->specification->getMetaObject());
        $this->specification->setJsonapi($this->specification->getJsonapiObject());

        return $this->specification->getApiData();
    }
}
