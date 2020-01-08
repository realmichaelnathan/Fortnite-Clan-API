<?php

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

// General Page Routes
$router->get('/search/{searchTerm}', 'PagesController@search');

// Authentication Routes
$router->post('/auth/register', 'UserController@store');
$router->post('/auth/login', 'AuthController@authenticate');

// Protected Routes. You must pass in a token to access these.
$router->group(
    ['middleware' => 'jwt.auth'], 
    function() use ($router) {
        $router->get('/users', 'UserController@index');
        $router->get('/user/{id}', 'UserController@show');

        $router->get('/clans', 'ClansController@index');
        $router->get('/clan/{id}', 'ClansController@show');

    }
);
