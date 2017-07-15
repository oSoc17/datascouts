
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
$app->get('/key', function () {
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

        $app->get('/', function () use ($app) {
            return response()->json([
                'route'=>[
                    'CRUD'  => 'entities/{id1,id2,id3}'
                ]
            ]);
        });
        $app->get('/zen', function () use ($app) {
            return response()->json(['joke' => 'Waiting for the joke. It\' comming ....']);
        });
        
        // Routes for resource ENTITIES
        $app->group(['prefix' => 'entities'], function ($app) {
            $app->get('/', 'EntitiesController@all');
            $app->get('/{id:[0-9]+}', 'EntitiesController@get');
            $app->get('/{url:[a-z-_]+}', 'EntitiesController@getByUrl');
            
            $app->post('/', 'EntitiesController@add');
            $app->put('/{id}', 'EntitiesController@put');
            $app->delete('/{id}', 'EntitiesController@remove');
            $app->get('/{id}/handles', 'EntitiesController@getHandles');
            $app->post('/{id}/handles', 'EntitiesController@addHandle');
        }); // prefix : entities


        // Routes for resource HANDLES
        $app->group(['prefix' => 'handles'], function ($app) {
            $app->get('', 'HandlesController@all');

            $app->get('/{id:[0-9]+}', 'HandlesController@get');
            $app->get('/{url:[a-z-_]+}', 'HandlesController@getByUrl');

            $app->post('/{id}', 'EntitiesController@addHandle');
            $app->post('/{handle_id}/services/{service_id}', 'HandlesController@addService');

            $app->put('/{id}', 'HandlesController@put');
            $app->delete('/{id}', 'HandlesController@remove');
        }); // prefix : handles


        // Routes for resource SERVICES
        $app->group(['prefix' => 'services'], function ($app) {
            $app->get('', 'ServicesController@all');
            $app->get('/{id}', 'ServicesController@get');
            $app->post('', 'ServicesController@add');
            $app->put('/{id}', 'ServicesController@put');
            $app->delete('/{id}', 'ServicesController@remove');
        }); // prefix : services

    }); // prefix : v1
});  // prefix : api

