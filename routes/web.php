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

use App\Http\Controllers\Admin\Content\CategoryController;

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/users', function () {
//   $users = \App\Models\User::all();
//    $role = \App\Models\Role::query()->find(1);
//    $permissions = \App\Models\RolePermission::all();
    $saeed = \App\Models\User::query()->find(1);

//    return response($saeed->role->userRole->permissions);


    $roleP = \App\Models\RolePermission::query()->find(4);
    return response($roleP->action);
});
