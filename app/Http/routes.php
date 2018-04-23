<?php

Route::get('home', 'HomeController@index');

Route::get('/', 'MainController@index',['middleware'=>'guest']);
Route::post('loginprocess','MainController@loginprocess');
Route::get('logout','HomeController@logout');


Route::get('/dashboard', 'DashboardController');

Route::resource('tasks', 'TaskController');

Route::get('api/users/present-by-date','User\GetPresentUsersByDate');
Route::resource('users','User\UserController');

Route::resource('complaints','ComplaintController');

Route::post('attendances/get-by-month-and-year', 'Attendance\GetByMonthAndYearForUser');
Route::post('attendances/get-by-date', 'Attendance\GetByDateController');
Route::resource('attendances','Attendance\AttendanceController');

Route::get('report','HomeController@report');
Route::post('viewreport','HomeController@viewreport');

Route::get('broadcast','HomeController@broadcast');
Route::get('notice/{id}','HomeController@notice');
Route::get('noticehistory','HomeController@noticehistory');
Route::get('deletenotice/{id}','HomeController@deletenotice');

Route::get('leave','HomeController@leave');
Route::post('makeleave','HomeController@makeleave');

Route::get('editprofile','HomeController@editprofile');
Route::post('editprocess','HomeController@editprocess');
Route::post('changepassword','HomeController@changePassword');

Route::post('broadcastprocess','HomeController@broadcastprocess');


Route::post('addusers','HomeController@addusers');
Route::get('edituser/{id}','HomeController@edituser');
Route::get('deleteuser/{id}','HomeController@deleteuser');
Route::get('/a','HomeController@ajax_users');
Route::get('/b','HomeController@select_user');
Route::get('/{username}','HomeController@profile');
