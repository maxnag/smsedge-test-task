<?php

namespace App\API\V1\Validators;


/**
 * API masterzoo academy
 * Validator class for city data
 *The param "date_to" is required
 * @package  api
 * @subpackage masterzoo academy
 * @author Maxim Nagaychenko nagaychenko.dev[at]gmail.com
 * @license
 * @filesource
 */
class LogRequestParamValidator extends AbstractValidator
{
    /**
     * Rules for validation
     *
     * @return array
     */
    protected function prepareRules(): array
    {
        $rules = [];

        foreach ($this->rawData as $key => $value) {
            switch ($key) {
                case 'date_from':
                case 'date_to':
                    $rules[$key] = 'required|date_format:Y-m-d';
            }
        }

        return $rules;
    }

    /**
     * Custom massages for validation
     *
     * return array
     */
    protected function messages(): array
    {
        $messageFile = 'logRequestParam';

        return [
            'date_from.required' => __($messageFile . '.date_from.required'),
            'date_to.required' => __($messageFile . '.date_to.required'),
        ];
    }
}
