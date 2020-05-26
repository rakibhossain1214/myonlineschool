<?php

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
    Route::get('/profile/mylocation/', 'DashboardController@location');

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
    Route::get('/course/view/{id}/video', 'Course\CourseController@video');

    Route::get('/course/view/{id}/notice', 'Course\NoticeController@index');
    Route::get('/course/view/{id}/notice/create', 'Course\NoticeController@create');
    Route::post('/course/view/{id}/notice/store', 'Course\NoticeController@store');
    Route::delete('/course/view/{id}/notice/delete/{id1}', ['uses'=>'Course\NoticeController@destroy', 'as'=>'notice-delete']);


    Route::get('/course/view/{id}/note', 'Course\NoteController@index');
    Route::get('/course/view/{id}/note/create', 'Course\NoteController@create');
    Route::post('/course/view/{id}/note/store', ['uses'=>'Course\NoteController@store', 'as'=>'course-note-upload']);
    // Route::post('/course/view/{id}/note/store', 'Course\NoteController@store');
    Route::delete('/course/view/{id}/note/delete/{id1}', ['uses'=>'Course\NoteController@destroy', 'as'=>'notice-delete']);

    
    Route::get('/course/view/{id}/student/', 'Course\CourseController@courseStudent');

    Route::get('/course/view/{id}/student/{id1}/edit', 'Course\CourseController@courseStudentEdit');
    Route::put('/course/view/{id}/student/{id1}/edit', ['uses'=>'CourseController@courseStudentUpdate', 'as'=>'student-update']);
    
    Route::delete('/course/view/{id}/student/{id1}/delete', 'Course\CourseController@courseStudentDelete');
    
});
