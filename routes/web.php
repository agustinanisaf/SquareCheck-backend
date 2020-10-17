<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->group(['prefix' => 'users'], function () use ($router) {
        $router->get('', [
            'as' => 'user.index', 'uses' => 'UserController@index'
        ]);

        $router->get('{id}', [
            'as' => 'user.show', 'uses' => 'UserController@show'
        ]);

        $router->post('', [
            'as' => 'user.store', 'uses' => 'UserController@store'
        ]);

        $router->put('{id}', [
            'as' => 'user.update', 'uses' => 'UserController@update'
        ]);

        $router->delete('{id}', [
            'as' => 'user.destroy', 'uses' => 'UserController@destroy'
        ]);

        $router->get('{id}/tokens', [
            'as' => 'user.token', 'uses' => 'UserController@getToken'
        ]);

        $router->post('{id}/tokens', [
            'as' => 'user.token', 'uses' => 'UserController@createToken'
        ]);

        // TODO: Add Student and Lecturer (and Admin, based on new Database design)
    });
});
