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
    return Clan::byId($id);
});

$router->get('/userclan/{id}', function ($id) {
    return Clan::byUserId($id);
});

$router->post(
    '/auth/login', 
    [
       'uses' => 'AuthController@authenticate'
    ]
);

$router->group(
    ['middleware' => 'jwt.auth'], 
    function() use ($router) {
        $router->get('/users', function() {
            $users = \App\User::all();
            return response()->json($users);
        });

        $router->get('/currentuser/{id}',['middleware' => 'clanowner', function (Request $request, $id) {
            
            return 'You made it in!';
        }]);
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