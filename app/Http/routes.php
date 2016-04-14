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
    Route::any('/home', 'HomeController@index');

    //admin pages
    Route::group(['namespace' => 'Admin', 'middleware' => 'admin', 'prefix' => 'admin'], function () {
        Route::get('/', 'AdminController@index');
        Route::get('/addProblems', 'AdminController@addProblems');
    });
});
