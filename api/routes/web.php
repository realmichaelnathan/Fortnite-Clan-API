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

$router->get('/', function () use ($router) {
    return ("Hello!");
});

$router->get('/clans', function() {
    $results = DB::select("SELECT * FROM clans LIMIT 50");
    return $results;
});

$router->get('/clans/new', function() {
    $results = DB::select("SELECT * FROM clans ORDER BY created_at DESC LIMIT 50");
    return $results;
}); 

$router->get('/clan/{id}', function ($id) {
    return Clan::whereId($id)->get();
});

$router->get('/userclan/{id}', function ($id) {
    return Clan::whereUserid($id)->first();
});

$router->post('/auth/login', 'AuthController@authenticate');

//  PROTECTED ROUTES. YOU MUST PASS IN A TOKEN TO ACCESS THESE ROUTES.
//  FOR EXAMPLE 'token' = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJsdW1lbi1qd3QiLCJzdWIiOjE'
$router->group(
    ['middleware' => 'jwt.auth'], 
    function() use ($router) {
        $router->get('/editclan', 'ClansController@index');
        $router->post('/editclan','ClansController@update');
        //$router->delete('/editclan', 'ClansController@destroy');
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