<?php

Route::get('home', 'HomeController@index');

Route::get('/', 'MainController@index',['middleware'=>'guest']);
Route::post('loginprocess','MainController@loginprocess');
Route::get('logout','HomeController@logout');


Route::get('/dashboard', 'HomeController@dashboard');
Route::get('users','HomeController@users');

Route::get('report','HomeController@report');
Route::post('viewreport','HomeController@viewreport');

Route::get('broadcast','HomeController@broadcast');
Route::get('notice/{id}','HomeController@notice');
Route::get('noticehistory','HomeController@noticehistory');
Route::get('deletenotice/{id}','HomeController@deletenotice');

Route::get('tasks','HomeController@tasks');

Route::get('complaint','HomeController@complaint');
Route::post('processcomplaint','HomeController@processcomplaint');
Route::get('deletecomplaint/{id}','HomeController@deletecomplaint');
Route::get('viewcomplaint/{id}','HomeController@viewcomplaint');

//Route::resource('/complaint','ComplaintController');

Route::get('leave','HomeController@leave');
Route::post('makeleave','HomeController@makeleave');

Route::get('editprofile','HomeController@editprofile');
Route::post('editprocess','HomeController@editprocess');
Route::post('changepassword','HomeController@changePassword');

Route::get('attendance','HomeController@attendance');
Route::post('makeattendance','HomeController@makeAttendance');
Route::post('viewattendance','HomeController@viewAttendance');
Route::post('viewempattendance','HomeController@viewEmpAttendance');

Route::post('assigntask','HomeController@assigntask');
Route::get('deletetask/{id}','HomeController@deletetask');
Route::post('broadcastprocess','HomeController@broadcastprocess');


Route::post('addusers','HomeController@addusers');
Route::get('edituser/{id}','HomeController@edituser');
Route::get('deleteuser/{id}','HomeController@deleteuser');
Route::get('/a','HomeController@ajax_users');
Route::get('/b','HomeController@select_user');
Route::get('/{username}','HomeController@profile');
