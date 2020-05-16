<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');



Route::group(['prefix'=>'dashboard', 'middleware'=>'auth'], function(){
    Route::get('/', 'DashboardController@index');
    Route::post('/', 'DashboardController@updateAvatar');
    Route::get('/profile/edit/{id}', ['uses'=>'DashboardController@edit', 'as'=>'profile-edit']);
    Route::put('/profile/edit/{id}', ['uses'=>'DashboardController@update', 'as'=>'profile-update']);


    Route::get('/course', 'Course\CourseController@index');
    Route::get('/course/create', 'Course\CourseController@create');
    Route::post('/course/store', 'Course\CourseController@store');
    Route::get('/course/edit/{id}', ['uses'=>'Course\CourseController@edit', 'as'=>'course-edit']);
    Route::put('/course/update/{id}', ['uses'=>'Course\CourseController@update', 'as'=>'course-update']);
    Route::delete('/course/delete/{id}', ['uses'=>'Course\CourseController@destroy', 'as'=>'course-delete']);

    Route::get('/message', 'Course\MessageController@index');
    Route::get('/message/sent', 'Course\MessageController@sent');
    Route::get('/message/create', 'Course\MessageController@create');
    Route::get('/message/read/{id}', 'Course\MessageController@read');
    Route::post('/message/store', 'Course\MessageController@store');
    Route::delete('/message/delete/{id}', ['uses'=>'Course\MessageController@destroy', 'as'=>'message-delete']);

    Route::get('/notification', 'MynotificationController@index');

    Route::get('/course/view/{id}', 'Course\CourseController@view');
    Route::post('/course/view/{id}', ['uses'=>'Course\CourseController@updateCoursePhoto', 'as'=>'course-photo-update']);

});
