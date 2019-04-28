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

use App\Clan;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use App\Closure;
use App\User;
use Illuminate\Support\Facades\Input;

// General Page Routes
$router->get('/clans', 'PagesController@index');
$router->get('/clans/new', 'PagesController@newclans'); 
$router->get('/viewclan/{id}', 'PagesController@viewclan');
$router->get('/search/{searchTerm}', 'PagesController@search');

// Authentication Routes
$router->post('/auth/register', 'UserController@register');
$router->post('/auth/login', 'AuthController@authenticate');

// Protected Routes. You must pass in a token to access these.
$router->group(
    ['middleware' => 'jwt.auth'], 
    function() use ($router) {
        $router->post('/addclan', 'ClansController@create');
        $router->get('/userclan', 'ClansController@userclan');

        $router->get('/editclan', 'ClansController@index');
        $router->post('/editclan','ClansController@update');
        $router->delete('/editclan', 'ClansController@destroy');

        $router->get('/getuser', 'UserController@getuser');
        $router->delete('/deleteuser', 'UserController@destroy');
    }
);

// Sanitize the html out of the description.
// $router->get('/sanitize', function() {
//     $results = DB::select("SELECT id, description FROM clans");
//     foreach($results as $result) {
//         $sanitized = htmlspecialchars_decode(strip_tags($result->description));
//         $sanitized = addslashes($sanitized);
//         DB::update("UPDATE clans SET description = '$sanitized' WHERE id = $result->id");
//     }
//     return "done";
// });