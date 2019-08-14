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

Route::middleware(['login', 'permission'])->group(function () {
    //角色管理
    Route::prefix('role')->group(function () {
        Route::any('index', 'RoleController@index');
        Route::any('add', 'RoleController@add');
        Route::any('edit', 'RoleController@edit');
        Route::any('del', 'RoleController@del');
        //获取角色的的权限
        Route::any('permission', 'RoleController@permission');
        //设置角色的权限
        Route::any('sync_permission', 'RoleController@sync_permission');
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
        Route::any('roles', 'UserController@roles');
        //更新用户的的角色
        Route::any('sync_roles', 'UserController@sync_roles');
    });
});
//获取用户权限列表
Route::any('user/permission', 'UserController@permission')->middleware(['login']);

//登陆
Route::any('login', 'LoginController@login');
//退出
Route::any('logout', 'LoginController@logout');