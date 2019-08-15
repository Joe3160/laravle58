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

Route::middleware(['login'])->group(function () {
    Route::prefix('home')->group(function () {
        //首页菜单
        Route::any('menu', 'HomeController@menu');
        //权限菜单-一级菜单--创建权限时选择分类使用
        Route::any('menu_title', 'HomeController@menu_title');
    });
});
//登陆
Route::any('login', 'LoginController@login');
//退出
Route::any('logout', 'LoginController@logout');