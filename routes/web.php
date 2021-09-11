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


$router->post('/register', ['uses' => 'AuthController@register']);
$router->post('/login', ['uses' => 'AuthController@login']);

$router->group(
    ['middleware' => 'jwt'],
    function () use ($router) {

        $router->get('/me', ['uses' => 'AuthController@show']);

        /** Course's routes */
        $router->get('/courses', ['uses' => 'CourseController@index']);
        $router->get('/courses/{course_id}', ['uses' => 'CourseController@show']);
        $router->get('/courses/{course_id}/packages', ['uses' => 'CourseController@getAllPackages']);
        $router->get('/courses/{course_id}/packages/{package_id}', ['uses' => 'CourseController@getPackage']);

        /** Package's routes */
        $router->get('/packages', ['uses' => 'PackageController@index']);
        $router->get('/packages/{id}', ['uses' => 'PackageController@show']);

        /** Sale's routes */
        $router->get('/sales', ['uses' => 'SaleController@index']);
        $router->get('/sales/{id}', ['uses' => 'SaleController@show']);

        $router->group(
            ['middleware' => 'role:admin'],
            function () use ($router) {

                /** Course's routes */
                $router->post('/courses', ['uses' => 'CourseController@store']);
                $router->put('/courses/{course_id}', ['uses' => 'CourseController@update']);
                $router->delete('/courses/{course_id}', ['uses' => 'CourseController@destroy']);

                /** Package's routes */
                $router->post('/packages', ['uses' => 'PackageController@store']);
                $router->put('/packages/{id}', ['uses' => 'PackageController@update']);
                $router->delete('/packages/{id}', ['uses' => 'PackageController@destroy']);

                /** Sale's routes */
                $router->post('/sales', ['uses' => 'SaleController@store']);
                $router->put('/sales/{id}', ['uses' => 'SaleController@update']);
                $router->delete('/sales/{id}', ['uses' => 'SaleController@destroy']);
            }
        );
    }
);
