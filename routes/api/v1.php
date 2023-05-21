<?php

/** @var \Laravel\Lumen\Routing\Router $router */



$router->get('/api/v1', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api/v1'], function () use ($router) {
    $router->group(['prefix' => 'users'], function () use ($router) {
        $router->post('','API\V1\UsersController@store');
        $router->put('','API\V1\UsersController@updateInfo');
        $router->put('change-password','API\V1\UsersController@updatePassword');
    });
   

    
});
