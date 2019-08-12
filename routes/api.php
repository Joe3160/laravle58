<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//角色管理
Route::prefix('role')->group(function () {
    Route::any('index', 'RoleController@index');
    Route::any('add', 'RoleController@add');
    Route::any('edit', 'RoleController@edit');
    Route::any('del', 'RoleController@del');
});

//权限管理
Route::prefix('permission')->group(function () {
    Route::any('index', 'PermissionController@index');
    Route::any('add', 'PermissionController@add');
    Route::any('edit', 'PermissionController@edit');
    Route::any('del', 'PermissionController@del');
});


//后台用户管理
Route::prefix('user')->group(function () {
    Route::any('index', 'UserController@index');
    Route::any('add', 'UserController@add');
    Route::any('edit', 'UserController@edit');
    Route::any('del', 'UserController@del');
    //获取用户的的角色
    Route::any('user_roles', 'UserController@user_roles');
});