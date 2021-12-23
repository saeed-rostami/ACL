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

use App\Http\Controllers\RoleController;

$router->get('/', function () use ($router) {
    return $router->app->version();
});

//ROLES
$router->get('/roles', 'RoleController@index');
$router->post('/create/role', 'RoleController@create');
$router->post('/update/role/{id}', 'RoleController@update');
$router->delete('/delete/role/{id}', 'RoleController@destroy');

$router->post('/assignRole', 'RoleController@assignRole');


//PERMISSIONS
$router->get('/permission', 'PermissionController@index');
$router->post('/create/permission', 'PermissionController@create');
$router->post('/update/permission/{id}', 'PermissionController@update');
$router->delete('/delete/permission/{id}', 'PermissionController@destroy');


//USER
$router->post('/user', 'UserController@index');
//$router->post('/create/user', 'UserController@create');
