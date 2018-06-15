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
Route::post('/forgotPassword', 'UtilController@sendMail');

Route::get('/', 'HomeController@get');

Route::post('/addteacherdayoff', 'ProfileController@addTeacherDayoff');
Route::post('/addteachingoffset', 'ProfileController@addTeachingOffset');
Route::post('/updateProfile', 'ProfileController@updateProfile');
Route::post('/updateAvatar','ProfileController@updateAvatar');
Route::post('/updatePassword','ProfileController@updatePassword');

Route::get('/profile', 'ProfileController@get');
Route::get('/getscorelist', 'ProfileController@getScoreList');
Route::get('/getSlot', 'ProfileController@getSlot');
Route::get('/getTeacherSchedule', 'ProfileController@getTeacherSchedule');
Route::get('/getTASchedule', 'ProfileController@getTASchedule');
Route::post('/getlistfreeteacher2', 'ProfileController@getAvailableTeacher');
Route::post('/updatescorelist', 'ProfileController@updateScoreList');

Route::get('/admin', 'AdminController@getData');
Route::post('/getlistfreeteacher', 'AdminController@getAvailableTeacher');
Route::get('/getlistfreeta', 'AdminController@getAvailableTA');

Route::get('/postroomlist', 'AdminController@postRoomList');
Route::get('/get_available_office', 'AdminController@getAvailableOffice');

Route::get('/getSalary', 'AdminController@getSalaryInMonth');
Route::get('/getScore', 'AdminController@getScore');

Route::get('/getAllRegister', 'AdminController@getAllRegister');
Route::get('/deleteRegister', 'AdminController@deleteRegister');

Route::get('/getAllSubject', 'AdminController@getAllSubject');
Route::get('/getSubject', 'AdminController@getSubject');
Route::post('/addSubject', 'AdminController@addSubject');
Route::post('/updateSubjectImg','AdminController@updateSubjectImg');
Route::get('/deleteSubject', 'AdminController@deleteSubject');

Route::get('/getAllCourse', 'AdminController@getAllCourse');
Route::get('/getCourseFromSub', 'AdminController@getCourseFromSub');
Route::get('/getCourse', 'AdminController@getCourse');
Route::post('/addCourse', 'AdminController@addCourse');
Route::post('/updateCourseImg','AdminController@updateCourseImg');
Route::get('/deleteCourse', 'AdminController@deleteCourse');

Route::get('/getAllOffice', 'AdminController@getAllOffice');
Route::get('/getOffice', 'AdminController@getOffice');
Route::post('/addOffice', 'AdminController@addOffice');
Route::get('/deleteOffice', 'AdminController@deleteOffice');

Route::get('/getAllRoom', 'AdminController@getAllRoom');
Route::get('/getRoom', 'AdminController@getRoom');
Route::post('/addRoom', 'AdminController@addRoom');
Route::get('/deleteRoom', 'AdminController@deleteRoom');

Route::get('/getAllEmployee', 'AdminController@getAllEmployee');
Route::get('/getEmployee', 'AdminController@getEmployee');
Route::post('/addEmployee', 'AdminController@addEmployee');
Route::get('/deleteEmployee', 'AdminController@deleteEmployee');

Route::get('/getAllWorker', 'AdminController@getAllWorker');
Route::get('/getWorker', 'AdminController@getWorker');
Route::post('/addWorker', 'AdminController@addWorker');
Route::get('/deleteWorker', 'AdminController@deleteWorker');

Route::get('/getEmployeeNotWorker', 'UtilController@getEmployeeExcludeOW');
Route::get('/getEmployeeNotTeacher', 'UtilController@getEmployeeExcludeTeacher');
Route::get('/getEmployeeNotTA', 'UtilController@getEmployeeExcludeTA');

Route::get('/getAllTeacher', 'AdminController@getAllTeacher');
Route::get('/getTeacher', 'AdminController@getTeacher');
Route::post('/addTeacher', 'AdminController@addTeacher');
Route::get('/deleteTeacher', 'AdminController@deleteTeacher');

Route::get('/getAllTA', 'AdminController@getAllTA');
Route::get('/getTA', 'AdminController@getTA');
Route::post('/addTA', 'AdminController@addTA');
Route::get('/deleteTA', 'AdminController@deleteTA');

Route::get('/getAllPromotion', 'AdminController@getAllPromotion');
Route::get('/getPromotion', 'AdminController@getPromotion');
Route::post('/addPromotion', 'AdminController@addPromotion');
Route::get('/deletePromotion', 'AdminController@deletePromotion');
Route::post('/editPromotion', 'AdminController@editPromotion');

Route::get('/getAllPosition', 'AdminController@getAllPosition');

Route::get('/getteacherschedule', 'AdminController@getTeacherScheduleInRange');

Route::get('/gettaschedule', 'AdminController@getTAScheduleInRange');

Route::get('/getRegisterBySubject', 'AdminController@countRegisterBySubjectInYear');
Route::get('/getRegisterByOffice', 'AdminController@countRegisterByOfficeInYear');
Route::get('/getReisterInMonth', 'AdminController@getRegisterInMonth');

Route::get('/{range_date}&{room_ids}', 'AdminController@getRoomScheduleList');

Route::get('/schedule', 'ScheduleController@get');
Route::get('/getSchedule', 'ScheduleController@getSchedule');
Route::post('/addClassRegister', 'ScheduleController@classRegister');
Route::get('/getAllSubject2', 'ScheduleController@getAllSubject');
Route::get('/getCourseFromSub2', 'ScheduleController@getCourseFromSub');
Route::get('/getAllOffice2', 'ScheduleController@getAllOffice');

Route::get('/office', 'OfficeController@get');

Route::get('/getsupervisors', 'AdminController@getSupervisors');

Route::post('/addclass', 'AdminController@addClass');

Route::post('/deleteclass', 'ClassManageController@deleteClass');

Route::get('/sendmail', 'UtilController@sendMail');





