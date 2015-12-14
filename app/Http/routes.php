<?php

use Rea\User as User;
use Illuminate\Http\Response as HttpResponse;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['domain' => 'rea.app', 'middleware' => 'cors'], function ()
{

// Sessions
Route::post('login',  array('as' => 'login', 'uses' => 'SessionController@store'));
Route::resource('session', 'SessionController');

// Users
Route::post(
  'user/give-role/{user}/{role}', 
  array('as' => 'give-role', 'uses' => 'UserController@giveRole')
);
Route::post(
  'user/retrieve-role/{user}/{role}', 
  array('as' => 'retrieve-role', 'uses' => 'UserController@retrieveRole')
);
Route::get('user/profile',  array('as' => 'profile', 'uses' => 'UserController@profile'));
Route::resource('user', 'UserController');

// Roles
Route::post(
  'role/give-permission/{role}/{permission}', 
  array('as' => 'give-permission', 'uses' => 'RoleController@givePermission')
);
Route::post(
  'role/retrieve-permission/{role}/{permission}', 
  array('as' => 'retrieve-permission', 'uses' => 'RoleController@retrievePermission')
);
Route::resource('role', 'RoleController');

// Permissions
Route::resource('permission', 'PermissionController');

// Stations
Route::get('station/{station}',  array('uses' => 'StationController@show'));

});