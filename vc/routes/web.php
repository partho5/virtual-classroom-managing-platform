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

Route::get('/', 'HomeController@showHomePage');


Route::group(['prefix' => '/', 'middleware' => 'UserRoleChecker'], function (){

});


Route::get('/user/board', 'UserController@index');



Route::get('/super', 'SuperAdminController@index');
Route::post('/super/invite_to_come_in_role', 'SuperAdminController@inviteToComeInRole');




Route::get('/representative', 'RepresentativeController@index');




Route::get('/speaker', 'SpeakerController@index');



Route::resource('/event', 'EventsController');
Route::post('/event/attend', 'EventsController@attendToEvent');
Route::post('/event/approve', 'EventsController@approveEvent');
Route::post('/event/delete', 'EventsController@deleteEvent');
Route::get('/event_create_helper/get_representative_names', 'EventsController@getSpeakerNames');



Route::resource('/user/profile', 'ProfileController');




Route::get('/invitation/respond_to_invitation/{token}', 'UserController@respondToInvitation');



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
