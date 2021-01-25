<?php

/** @var Router $router */

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

use Laravel\Lumen\Routing\Router;

$router->group(['middleware' => 'intId'], function () use ($router) {
    $router->get('client/{id}', 'ClientController@view');
    $router->get('account/{id}', 'AccountController@view');
    $router->get('account/{id}/history', 'AccountController@history');
    $router->post('transfer', 'TransferController@create');
});
