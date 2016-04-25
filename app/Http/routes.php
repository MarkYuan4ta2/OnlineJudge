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

//public pages
Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'web'], function () {
    Route::auth();

    //login user pages
    Route::group(['namespace' => 'User'], function () {
        Route::group(['middleware' => 'auth'], function () {
            //personal home page
            Route::any('/home', 'UserController@home');

            //problems related
            Route::get('/problems', 'ProblemsController@index');
            Route::get('/problemDetail', 'ProblemsController@problemDetail');
            Route::post('/receiveCode', 'ProblemsController@receiveCode');
            Route::post('/submissionResult', 'ProblemsController@submissionResult');

            //submissions related
            Route::get('/submissions', 'ProblemsController@userSubmissions');
            Route::get('/submissionDetail', 'ProblemsController@submissionDetail');
        });
    });

    //admin pages
    Route::group(['namespace' => 'Admin', 'middleware' => 'admin', 'prefix' => 'admin'], function () {
        Route::get('/', 'AdminController@index');

        Route::get('/list_problems', 'AdminController@listProblems');
        Route::get('/add_problems', 'AdminController@addProblems');
        Route::get('/edit_problems', 'AdminController@editProblems');
        Route::get('/delete_problems', 'AdminController@deleteProblems');
        Route::post('/save_problem', 'AdminController@saveProblems');//接收从add和edit传过来的表单

        Route::get('/list_classification','AdminController@listClassifications');
        Route::get('/delete_classification', 'AdminController@deleteClassifications');
        Route::post('/save_classification','AdminController@saveClassifications');

        Route::get('/user_list','AdminController@listUsers');
        Route::post('/save_user_info', 'AdminController@saveUserInfo');
    });
});
