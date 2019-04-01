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

$router->get('/viewclan/{id}', function ($id) {
    $results = DB::select("SELECT * FROM clans WHERE id = $id");
    return $results;
});

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