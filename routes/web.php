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

/**
 * https://lumen.laravel.com/docs/8.x
 */

$router->get('/', function () {
    return response()->json(['message' => 'Your API is ready 🙌']);
});


$router->post('/register', ['uses' => 'AuthController@register', 'as' => 'auth.register']);
$router->post('/login', ['uses' => 'AuthController@login', 'as' => 'auth.login']);

$router->group(
    ['middleware' => 'jwt'],
    function () use ($router) {

        $router->get('/courses', ['uses' => 'CourseController@index', 'as' => 'courses']);

        $router->group(
            ['middleware' => 'role:admin'],
            function () use ($router) {

                $router->post('/courses', ['uses' => 'CourseController@store', 'as' => 'courses.store']);
                $router->get('/courses/{id}', ['uses' => 'CourseController@show', 'as' => 'courses.show']);
                $router->put('/courses/{id}', ['uses' => 'CourseController@update', 'as' => 'courses.update']);
                $router->delete('/courses/{id}', ['uses' => 'CourseController@destroy', 'as' => 'courses.destroy']);
            }
        );

        $router->get('/packages', ['uses' => 'PackageController@index', 'as' => 'packages']);

        $router->group(
            ['middleware' => 'role:admin'],
            function () use ($router) {

                $router->post('/packages', ['uses' => 'PackageController@store', 'as' => 'packages.store']);
                $router->get('/packages/{id}', ['uses' => 'PackageController@show', 'as' => 'packages.show']);
                $router->put('/packages/{id}', ['uses' => 'PackageController@update', 'as' => 'packages.update']);
                $router->delete('/packages/{id}', ['uses' => 'PackageController@destroy', 'as' => 'packages.destroy']);
            }
        );
    }
);
