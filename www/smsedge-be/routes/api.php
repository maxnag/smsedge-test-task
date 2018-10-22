<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/** @var Dingo\Api\Routing\Router $api */
$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    /** @var Dingo\Api\Routing\Router $api */
    /*
    |--------------------------------------------------------------------------
    | Routes for model SendLogAggregatedController
    |--------------------------------------------------------------------------
    */
    $api->group(['middleware' => []], function ($api) {
        /** @var Dingo\Api\Routing\Router $api */
        $api->get('logs', 'App\API\V1\Controllers\SendLogAggregatedController@index')->name('logs.get');
        $api->get('log/{id}', 'App\API\V1\Controllers\SendLogAggregatedController@index')->name('log.get');

        $api->get('users', 'App\API\V1\Controllers\UserController@index')->name('users.get');
        $api->get('user/{id}', 'App\API\V1\Controllers\UserController@index')->name('user.get');

        $api->get('countries', 'App\API\V1\Controllers\CountryController@index')->name('countries.get');
        $api->get('country/{id}', 'App\API\V1\Controllers\CountryController@index')->name('country.get');
    });
});
