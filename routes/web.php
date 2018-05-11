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
Route::post('/login','LoginController@postLogin');
Route::get('/logout', 'LoginController@logout');
Route::post('/adduser', 'LoginController@addUser');
Route::get('/', function () {
    return view('homepage');
});
Route::get('/admin', 'AdminController@getData');
Route::get('/profile', 'ProfileController@get');
Route::get('/subject_{id}', 'SubjectController@get');
Route::get('/getlistfreeteacher', 'AdminController@getAvailableTeacher');

Route::get('/getclassfromcourse{id}', 'SubjectController@getClassFromCourse');
Route::post('/classregister', 'SubjectController@classRegister');

Route::get('/schedule', 'ScheduleController@get');
Route::get('/getschedule', 'ScheduleController@getschedule');

Route::get('/postroomlist', 'AdminController@postroomlist');
Route::get('/get_available_office', 'AdminController@getAvailableOffice');

Route::post('/addteacherdayoff', 'ProfileController@addTeacherDayoff');
Route::post('/addteachingoffset', 'ProfileController@addTeachingOffset');

Route::get('/{range_date}&{room_ids}', 'AdminController@getRoomScheduleList');

Route::get('/getSalary', 'AdminController@getSalaryInMonth');
Route::get('/getScore', 'AdminController@getScore');
Route::post('/updateScore', 'AdminController@updateScore');

Route::get('/getAllSubject', 'AdminController@getAllSubject');
Route::get('/getSubject', 'AdminController@getSubject');
Route::post('/addSubject', 'AdminController@addSubject');
Route::get('/deleteSubject', 'AdminController@deleteSubject');

Route::get('/getAllCourse', 'AdminController@getAllCourse');
Route::get('/getCourseFromSub', 'AdminController@getCourseFromSub');
Route::get('/getCourse', 'AdminController@getCourse');
Route::post('/addCourse', 'AdminController@addCourse');
Route::get('/deleteCourse', 'AdminController@deleteCourse');

Route::get('/getAllOffice', 'AdminController@getAllOffice');
Route::get('/getOffice', 'AdminController@getOffice');
Route::post('/addOffice', 'AdminController@addOffice');
Route::get('/deleteOffice', 'AdminController@deleteOffice');

Route::get('/getteacherschedule', 'AdminController@getTeacherScheduleInRange');
