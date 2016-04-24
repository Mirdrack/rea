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

Route::group(['domain' => env('DOMAIN'), 'middleware' => 'cors'], function ()
{

    // Sessions
    Route::post('login',  array('as' => 'login', 'uses' => 'SessionController@store'));
    Route::resource('session', 'SessionController');

    // Users
    Route::post(
      'user/recovery-password/{email}',
      array('as' => 'recovery-password', 'uses' => 'UserController@recoveryPassword')
    );
    Route::post(
      'user/change-password',
      array('as' => 'change-password', 'uses' => 'UserController@changePassword')
    );
    Route::post(
      'user/give-role/{user}/{role}', 
      array('as' => 'give-role', 'uses' => 'UserController@giveRole')
    );
    Route::post(
      'user/retrieve-role/{user}/{role}', 
      array('as' => 'retrieve-role', 'uses' => 'UserController@retrieveRole')
    );
    Route::post(
      'user/check-permissions', 
      array('as' => 'permissions', 'uses' => 'UserController@permissions')
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
    Route::get('station/basic-list', array('uses' => 'StationController@basicList'));
    Route::get('station/{station}', array('uses' => 'StationController@show'));
    Route::get('station', array('uses' => 'StationController@index'));
    Route::post(
      'station/turn-on', 
      array('as' => 'turn-on', 'uses' => 'StationController@turnOn')
    );
    Route::post(
      'station/turn-off', 
      array('as' => 'turn-off', 'uses' => 'StationController@turnOff')
    );
    Route::resource('station', 'StationController');

    // Reads
    Route::resource('read', 'ReadController');

    // Station Events
    Route::resource('station-event', 'StationEventController');

    // Station Alarms
    Route::resource('station-alarm', 'StationAlarmController');

    // Station Sensors
    Route::resource('station-sensor', 'StationSensorController');

    // Reports
    Route::post(
    	'chart/dynamic-level-chart', 
    	array('as' => 'dynamic-level-chart', 'uses' => 'ChartController@dynamicLevelChart')
    );
    Route::post(
      'chart/generate', 
      array('as' => 'generate', 'uses' => 'ChartController@generate')
    );
    Route::get(
      'chart/generate-xls/{stationId}/{start}/{end}/{lapse}', 
      array('as' => 'generate', 'uses' => 'ChartController@generateXls')
    );

});


// Password resets
Route::post(
  'password/recovery',
  array('as' => 'recovery', 'uses' => 'PasswordController@recovery')
);

Route::post(
  'password/reset',
  array('as' => 'reset', 'uses' => 'PasswordController@reset')
);