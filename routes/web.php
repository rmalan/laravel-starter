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

Auth::routes(['verify' => true]);

Route::get('/', 'DashboardController@index')->middleware(['auth', 'verified']);
Route::get('/permissions', 'PermissionController@index')->middleware('auth');
Route::post('/permissions', 'PermissionController@store')->middleware('auth');
Route::get('/permissions/{id}', 'PermissionController@edit')->middleware('auth');
Route::patch('/permissions/{permission}', 'PermissionController@update')->middleware('auth');
Route::delete('/permissions/{permission}', 'PermissionController@destroy')->middleware('auth');
Route::resource('/roles', 'RoleController')->middleware('auth');
Route::resource('/users', 'UserController')->middleware('auth');
Route::get('/my-account', 'MyAccountController@show')->middleware('auth');
Route::post('/my-account', 'MyAccountController@updateAccount')->middleware('auth');
Route::post('/my-account/update-password', 'MyAccountController@updatePassword')->middleware('auth');