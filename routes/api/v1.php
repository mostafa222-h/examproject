<?php

/** @var \Laravel\Lumen\Routing\Router $router */



$router->get('/api/v1', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api/v1'], function () use ($router) {
    $router->group(['prefix' => 'users'], function () use ($router) {
        $router->get('','API\V1\UsersController@index');
        $router->post('','API\V1\UsersController@store');
        $router->put('','API\V1\UsersController@updateInfo');
        $router->put('change-password','API\V1\UsersController@updatePassword');
        $router->delete('','API\V1\UsersController@delete');
    });
   
    $router->group(['prefix' => 'categories'], function () use ($router) {
        $router->get('','API\V1\CategorisController@index');
        $router->post('','API\V1\CategorisController@store');
        $router->delete('','API\V1\CategorisController@delete');
        $router->put('','API\V1\CategorisController@update');
      
    });

    $router->group(['prefix' => 'quizzes'], function () use ($router) {
        $router->get('','API\V1\QuizzesController@index');
        $router->post('','API\V1\QuizzesController@store');
       $router->delete('','API\V1\QuizzesController@delete');
        $router->put('','API\V1\QuizzesController@update');
      
    });


    $router->group(['prefix' => 'questions'], function () use ($router) {
        $router->get('','API\V1\QuestionsController@index');
        $router->post('','API\V1\QuestionsController@store');
        $router->delete('','API\V1\QuestionsController@delete');
        $router->put('','API\V1\QuestionsController@update');
      
    });

    
    $router->group(['prefix' => 'answer-sheets'], function () use ($router) {
        $router->get('','API\V1\AnswerSheetsController@index');
        $router->post('','API\V1\AnswerSheetsController@store');
        $router->delete('','API\V1\AnswerSheetsController@delete');
        //$router->put('','API\V1\AnswerSheetsController@update');
      
    });


    
});
