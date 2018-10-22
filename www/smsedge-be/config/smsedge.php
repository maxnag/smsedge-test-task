<?php

return [
    'Storage' => [
        'MySQL' => [
            'adapter' => 'MySQL',
            'group' => 'mysql',
        ],
        'Json' => [
            'adapter' => 'Json',
        ],
        'JsonAPI' => [
            'adapter' => 'JsonAPI',
        ],
    ],
    'API' => [
        'Jsonapi' => 'application/vnd.api+jsonapi',
        'Json' => 'application/json',
        //'HAL' => 'application/hal+json',
    ],
    'Registry' => [
        'V1' => [
            'UserMySQL' => App\API\V1\Adapters\MySQL\UserMySQL::class,
            'CountryMySQL' => App\API\V1\Adapters\MySQL\CountryMySQL::class,
            'SendLogAggregatedMySQL' => App\API\V1\Adapters\MySQL\SendLogAggregatedMySQL::class,
            'Map' => App\API\V1\Classes\MapIdentity::class,
        ]
    ]
];
