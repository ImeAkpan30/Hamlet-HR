<?php


$api = app('Dingo\Api\Routing\Router');


/**
 * Authentication Routes
 */


$api->version('v1', function ($api) {
    $groupOptions = [
        'namespace' => 'Hamlet\Modules\Auth\Api\v1\Controllers',
        'prefix' => 'auth',
    ];

    $api->group($groupOptions, function ($api) {
        // User Access Routes
        $api->get('/','AuthController@index');
    });
});

