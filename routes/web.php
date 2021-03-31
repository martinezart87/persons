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

Route::get('/', function () {
    return view('home');
});

$router->group(['prefix'=>'api/v1'], function() use($router){
    $router->get('/persons', 'PersonController@index');
    $router->post('/persons', 'PersonController@create');
    $router->get('/persons/{id:[0-9]+}', 'PersonController@show');
    $router->put('/persons/{id:[0-9]+}', 'PersonController@update');
    $router->delete('/persons/{id:[0-9]+}', 'PersonController@destroy');
});
