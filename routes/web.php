<?php

$router->get('home', 'HomeController@index');

$router->get('/', 'MainController@index',['middleware'=>'guest']);
$router->post('loginprocess','MainController@loginprocess');
$router->get('logout','HomeController@logout');


$router->get('/dashboard', 'DashboardController');

$router->resource('tasks', 'TaskController');

$router->get('api/users/present-by-date','User\GetPresentUsersByDate');
$router->post('profile/change-password','User\ChangePassword');
$router->post('profile/update','User\ChangeProfile@update');
$router->get('profile/edit','User\ChangeProfile@index');
$router->resource('users','User\UserController');

$router->resource('complaints','ComplaintController');

$router->post('attendances/get-by-month-and-year', 'Attendance\GetByMonthAndYearForUser');
$router->post('attendances/get-by-date', 'Attendance\GetByDateController');
$router->resource('attendances','Attendance\AttendanceController');

$router->get('report','HomeController@report');
$router->post('viewreport','HomeController@viewreport');

$router->resource('notices', 'Notice\NoticeController');

$router->get('leave','HomeController@leave');
$router->post('makeleave','HomeController@makeleave');

$router->get('editprofile','HomeController@editprofile');
$router->post('editprocess','HomeController@editprocess');
$router->post('changepassword','HomeController@changePassword');

$router->post('broadcastprocess','HomeController@broadcastprocess');


$router->post('addusers','HomeController@addusers');
$router->get('edituser/{id}','HomeController@edituser');
$router->get('deleteuser/{id}','HomeController@deleteuser');
$router->get('/a','HomeController@ajax_users');
$router->get('/b','HomeController@select_user');
$router->get('/{username}','HomeController@profile');
