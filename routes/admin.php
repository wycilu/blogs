<?php

//管理后台
Route::group(['prefix' => 'admin'],function (){

    //登陆展示页面
    Route::get('/login','\App\Admin\Controllers\LoginController@index');
    //登陆行为
    Route::post('/login','\App\Admin\Controllers\LoginController@login');
    //登出行为
    Route::get('/logout','\App\Admin\Controllers\LoginController@logout');

    Route::group(['middleware' => 'auth:admin'],function (){
        //首页
        Route::get('/home','\App\Admin\Controllers\HomeController@index');

        Route::group(['middleware' => 'can:system'],function () {
            //管理人员模块
            Route::get('/users','\App\Admin\Controllers\UserController@index');
            Route::get('/users/create','\App\Admin\Controllers\UserController@create');
            Route::post('/users/store','\App\Admin\Controllers\UserController@store');
            //用户和角色关系
            Route::get('/users/{user}/role','\App\Admin\Controllers\UserController@role');
            Route::post('/users/{user}/role','\App\Admin\Controllers\UserController@storeRole');

            //角色
            Route::get('/roles','\App\Admin\Controllers\RoleController@index');
            //创建角色页面
            Route::get('/roles/create','\App\Admin\Controllers\RoleController@create');
            Route::post('/roles/store','\App\Admin\Controllers\RoleController@store');
            //角色和权限关系
            Route::get('/roles/{role}/permission','\App\Admin\Controllers\RoleController@permission');
            Route::post('/roles/{role}/permission','\App\Admin\Controllers\RoleController@storePermission');

            //权限
            Route::get('/permissions','\App\Admin\Controllers\PermissionController@index');
            //创建权限页面
            Route::get('/permissions/create','\App\Admin\Controllers\PermissionController@create');
            Route::post('/permissions/store','\App\Admin\Controllers\PermissionController@store');
        });

        Route::group(['middleware' => 'can:post'],function () {
            //审核文章模块
            Route::get('/posts','\App\Admin\Controllers\PostController@index');
            Route::post('/posts/{post}/status','\App\Admin\Controllers\PostController@status');
        });

        Route::group(['middleware' => 'can:topic'],function () {
            //专题
            Route::resource('topics','\App\Admin\Controllers\TopicController',['only' => ['index','create','store','destroy']]);
        });

        Route::group(['middleware' => 'can:notice'],function () {
            //专题
            Route::resource('notices','\App\Admin\Controllers\NoticeController',['only' => ['index','create','store']]);
        });
    });

});