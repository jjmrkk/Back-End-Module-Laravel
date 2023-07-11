<?php

Route::post('login', 'Api\Auth\LoginController@login');

Route::group(['middleware' => 'auth:api'], function()
{

Route::post('user/password', 'Api\Auth\ResetPasswordController@reset');
Route::get('user/logout', 'Api\Auth\LogoutController@logout');

    /******************** Start Metropolis Module ********************/
Route::post('msstest/record/forms', 'Api\MSSTest\Form\FormController@pdf');
Route::post('msstest/record/checkout', 'Api\MSSTest\Record\RecordController@update');
Route::get('msstest/record/visitor_detail/{id}', 'Api\MSSTest\Record\RecordController@visitor_detail');

Route::get('msstest/record/{search}', 'Api\MSSTest\Record\RecordController@show');
Route::get('msstest/record/filter/{date_from}/{date_to}/{checkbox1}', 'Api\MSSTest\Record\RecordController@filter');
Route::apiResource('msstest/record', 'Api\MSSTest\Record\RecordController');

Route::get('msstest/registration/{action}', 'Api\MSSTest\Registration\RegistrationController@show_maintenance');
Route::apiResource('msstest/registration', 'Api\MSSTest\Registration\RegistrationController');
    /******************** End Metropolis Module ********************/
});

    /******************** Start Test Module NO API ********************/
Route::apiResource('msstest/module', 'Api\MSSTest\User\ModuleController');
Route::post('msstest/user/store', 'Api\MSSTest\User\UserController@store');
Route::post('msstest/user/update', 'Api\MSSTest\User\UserController@update_access');
Route::get('msstest/user/access/{id}', 'Api\MSSTest\User\UserController@access');
Route::apiResource('msstest/user', 'Api\MSSTest\User\UserController');
  /**************************** End Test Module ********************/