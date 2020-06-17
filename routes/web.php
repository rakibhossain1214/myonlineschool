<?php



Auth::routes();

Route::get('/', 'HomeController@index');

Route::get('/home', 'HomeController@index');

Route::get('/apply', 'HomeController@apply');
Route::post('/apply-store', 'HomeController@applyStore');

Route::get('/all-courses', 'HomeController@allCourses');

Route::get('/terms', 'HomeController@terms');

Route::get('/privacy', 'HomeController@privacy');

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
    Route::get('/course/view/{id}/book', 'Course\CourseController@bookCourse');
    Route::post('/course/view/{id}/book', 'Course\CourseController@bookCourseStore');

    Route::get('/course/view/{id}/notice', 'Course\NoticeController@index');
    Route::get('/course/view/{id}/notice/create', 'Course\NoticeController@create');
    Route::post('/course/view/{id}/notice/store', 'Course\NoticeController@store');
    Route::delete('/course/view/{id}/notice/delete/{id1}', ['uses'=>'Course\NoticeController@destroy', 'as'=>'notice-delete']);


    Route::get('/course/view/{id}/note', 'Course\NoteController@index');
    Route::get('/course/view/{id}/note/create', 'Course\NoteController@create');
    Route::post('/course/view/{id}/note/store', ['uses'=>'Course\NoteController@store', 'as'=>'course-note-upload']);
    // Route::post('/course/view/{id}/note/store', 'Course\NoteController@store');
    Route::delete('/course/view/{id}/note/delete/{id1}', ['uses'=>'Course\NoteController@destroy', 'as'=>'note-delete']);

    Route::get('/course/view/{id}/assignment', 'Course\AssignmentController@index');
    Route::get('/course/view/{id}/assignment/create', 'Course\AssignmentController@create');
    Route::post('/course/view/{id}/assignment/store', ['uses'=>'Course\AssignmentController@store', 'as'=>'course-assigment-upload']);
    Route::delete('/course/view/{id}/assignment/delete/{id1}', ['uses'=>'Course\AssignmentController@destroy', 'as'=>'assignment-delete']);

    Route::get('/course/view/{id}/assignment/submit/{id1}', 'Course\AssignmentController@submit');
    Route::post('/course/view/{id}/assignment/submit/{id1}/store', 'Course\AssignmentController@assignmentStore');
    Route::get('/course/view/{id}/assignment/assignment-marks', 'Course\AssignmentController@assignmentMarks');
    Route::get('/course/view/{id}/assignment/submission/{id1}', 'Course\AssignmentController@assignmentSubmissions');
    Route::get('/course/view/{id}/assignment/submission/edit/{id1}',  'Course\AssignmentController@evaluate');
    Route::post('/course/view/{id}/assignment/submission/store/{id1}',  'Course\AssignmentController@evaluateStore');

    Route::get('/course/view/{id}/student/', 'Course\CourseController@courseStudent');
    

   
    Route::get('/course/view/{id}/update-result/{id1}',  'Course\CourseController@courseStudentEdit');
    Route::put('/course/view/{id}/update-result/{id1}/store',  'Course\CourseController@courseStudentStore');
    Route::put('/course/view/{id}/update-status',  'Course\CourseController@updateStatus');

    Route::delete('/course/view/{id}/delete-student/{id1}', 'Course\CourseController@courseStudentDelete');
    
    //Student Routes
    Route::get('/course/student/', 'Course\CourseController@index');


    Route::get('api/message', 'Course\MessageController@api');

    //admin
    Route::get('/course/all-courses', 'Admin\AdminController@index');
    Route::get('/course/checkouts', 'Admin\AdminController@checkout');
    Route::post('/course/checkouts/{id}', 'Admin\AdminController@manage');
    Route::delete('/course/checkouts/{id}/delete', 'Admin\AdminController@delete');

    Route::get('/all-users', 'Admin\AdminController@users');
    Route::get('/all-users/edit/{id}', 'Admin\AdminController@userEdit');
    Route::get('/all-users/add', 'Admin\AdminController@addUser');
    Route::post('/all-users/store', 'Admin\AdminController@storeUser');
    Route::post('/all-users/edit/{id}/store', 'Admin\AdminController@userEditStore');
    Route::delete('/all-users/{id}/delete', 'Admin\AdminController@deleteUser');

    Route::get('/applications', 'Admin\AdminController@applicationList');
    Route::get('/applications/approve/{id}', 'Admin\AdminController@applicationUpdate');
    Route::post('/applications/approve/{id}/store', 'Admin\AdminController@storeApplication');
    
    Route::get('/course/view/{id}/report',  'Course\CourseController@report');
    Route::post('/course/view/{id}/report/store',  'Course\CourseController@storeReport');

    Route::get('/reports', 'Admin\AdminController@reportList');

    Route::get('/manage-teacher', 'Admin\AdminController@teacherList');
    Route::get('/teacher/edit/{id}', 'Admin\AdminController@teacherEdit');
    Route::put('/teacher/edit/{id}/store', 'Admin\AdminController@teacherStore');
    Route::delete('/teacher/delete/{id}/', 'Admin\AdminController@teacherDelete');

    Route::get('/my-salary/{id}', 'Admin\AdminController@withdrawSalary');
    Route::put('/my-salary/{id}/store', 'Admin\AdminController@withdrawStore');
});
