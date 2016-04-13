<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

//用户页面命名空间
Route::group(['namespace' => 'User'], function () {
    Route::get('/problems', 'ProblemsController@index');
    Route::get('/problemDetail', 'ProblemsController@problemDetail');
});

Route::group(['middleware' => 'web'], function () {
    Route::auth();
    Route::get('/home', 'HomeController@index');
    Route::get('/admin', 'AdminController@index');

    Route::group(['namespace' => 'Admin', 'middleware' => 'adminCheck'], function () {
        Route::get('admin/login', 'AuthController@getLogin');
        Route::get('admin/register', 'AuthController@getRegister');
        Route::post('admin/login', 'AuthController@postLogin');
        Route::post('admin/register', 'AuthController@postRegister');
    });
});
