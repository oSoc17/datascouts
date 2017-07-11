
<?php

/*
|--------------------------------------------------------------------------
| Application Routes : /
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return $app->version();
});

// To generate the key for the .env
// https://stackoverflow.com/questions/30344141/lumen-micro-framework-php-artisan-keygenerate
$app->get('/key', function() {
    return response()->json(str_random(32));
});



/*
|--------------------------------------------------------------------------
| Application Routes : /api/v1
|--------------------------------------------------------------------------
|
| Those following routes must be prefixed 
|
*/

$app->group(['prefix' => 'api'], function ($app) { 

    $app->group(['prefix' => 'v1'], function ($app) { 

        $app->get('/zen', function () use ($app) {
            return response()->json(['joke' => 'Waiting for the joke. It\' comming ....']);
        });
        
        // Routes for resource entities
        $app->group(['prefix' => 'entities'], function ($app) {
            $app->get('/', 'EntitiesController@all');
            $app->get('/{id}', 'EntitiesController@get');
            $app->post('/', 'EntitiesController@add');
            $app->put('/{id}', 'EntitiesController@post');
            $app->delete('/{id}', 'EntitiesController@remove');
        }); // prefix : entities


    }); // prefix : v1
});  // prefix : api

