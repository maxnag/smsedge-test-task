<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Laravel CORS
    |--------------------------------------------------------------------------
    |
    | allowedOrigins, allowedHeaders and allowedMethods can be set to array('*')
    | to accept any value.
    |
    */
   
    'supportsCredentials' => true,
    'allowedOrigins' => ['*'],
    'allowedHeaders' => ['Accept', 'Content-Type', 'Authorization'],
    'allowedMethods' => ['GET', 'POST', 'PATCH', 'DELETE', 'OPTIONS'],
    'exposedHeaders' => [],
    'maxAge' => 0,

];
