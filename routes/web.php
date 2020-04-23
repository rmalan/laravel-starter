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
// Permissions
Route::get('/permissions', 'PermissionController@index')->middleware('auth');
Route::post('/permissions', 'PermissionController@store')->middleware('auth');
Route::get('/permissions/{id}', 'PermissionController@edit')->middleware('auth');
Route::patch('/permissions/{permission}', 'PermissionController@update')->middleware('auth');
Route::delete('/permissions/{permission}', 'PermissionController@destroy')->middleware('auth');
// Users
// Route::get('/users', 'UsersController@index');
// Route::get('/users/create', 'UsersController@create');
// Route::get('/users/{user}', 'UsersController@show');
// Route::post('/users', 'UsersController@store');
// Route::delete('/users/{user}', 'UsersController@destroy');
// Route::get('/users/{user}/edit', 'UsersController@edit');
// Route::patch('/users/{user}', 'UsersController@update');
Route::resource('/users', 'UserController')->middleware('auth');