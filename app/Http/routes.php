<?php

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
//Setting route to post controller
Route::get('/', 'JobsController@index');
Route::get('/home', ['as' => 'home', 'uses' => 'JobsController@index']);

//Setting the authenications
Route::get('auth/logout', 'Auth\AuthController@logout');
Route::controllers(['auth' => 'Auth\AuthController', 'password' => 'Auth\PasswordController']);

Route::group(['routeMiddleware' => ['auth']], function()
{
Route::get('new-job-post', 'JobsController@create');

Route::post('new-job-post', 'JobsController@store');

Route::get('edit/{slug}', 'JobsController@edit');
Route::post('update', 'JobsController@update');

Route::get('delete/{id}', 'JobsController@destroy');

Route::post('comment/add', "CommentsController@store");

});

Route::get('/{slug}', ['as' => 'job', 'uses' => 'JobsController@show']);

