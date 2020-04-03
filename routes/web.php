<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes([
    'register' => false,
    'reset' => false
]);

Route::get('/', 'DashboardController@index')->middleware('auth');
// User Groups
Route::get('/user-groups', 'UserGroupsController@index')->middleware('auth');
Route::post('/user-groups', 'UserGroupsController@store')->middleware('auth');
Route::get('/user-groups/{id}', 'UserGroupsController@edit')->middleware('auth');
Route::patch('/user-groups/{userGroup}', 'UserGroupsController@update')->middleware('auth');
Route::delete('/user-groups/{userGroup}', 'UserGroupsController@destroy')->middleware('auth');
// Users
// Route::get('/users', 'UsersController@index');
// Route::get('/users/create', 'UsersController@create');
// Route::get('/users/{user}', 'UsersController@show');
// Route::post('/users', 'UsersController@store');
// Route::delete('/users/{user}', 'UsersController@destroy');
// Route::get('/users/{user}/edit', 'UsersController@edit');
// Route::patch('/users/{user}', 'UsersController@update');
Route::resource('/users', 'UsersController')->middleware('auth');

Route::get('/home', 'HomeController@index')->name('home');
