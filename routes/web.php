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
Route::get('/getcoursefromsub{id}', 'AdminController@getCourseFromSub');
Route::get('/getcourse{id}', 'AdminController@getCourse');
Route::get('/deletecourse{id}', 'AdminController@deleteCourse');

Route::post('/addcourse', 'AdminController@addCourse');
Route::post('/updatecourse', 'AdminController@updateCourse');

Route::get('/getclassfromcourse{id}', 'SubjectController@getClassFromCourse');
Route::post('/classregister', 'SubjectController@classRegister');

Route::get('/schedule', 'ScheduleController@get');
Route::get('/getschedule', 'ScheduleController@getschedule');

Route::get('/postroomlist', 'AdminController@postroomlist');

Route::get('/{range_date}&{room_ids}', 'AdminController@getRoomScheduleList');

