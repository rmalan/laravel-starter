<?php

use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MyAccountController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
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

Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);

    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);

    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('password/confirm', [ConfirmPasswordController::class, 'showConfirmForm'])->name('password.confirm');
    Route::post('password/confirm', [ConfirmPasswordController::class, 'confirm']);
});

Route::middleware('auth')->group(function () {
    Route::get('email/verify', [VerificationController::class, 'show'])->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->middleware('signed')->name('verification.verify');
    Route::post('email/resend', [VerificationController::class, 'resend'])->middleware('throttle:6,1')->name('verification.resend');
});

Route::get('/', function() {
    return redirect('/dashboard');
});
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified']);
Route::get('/permissions', [PermissionController::class, 'index'])->middleware('auth');
Route::post('/permissions', [PermissionController::class, 'store'])->middleware('auth');
Route::get('/permissions/{id}', [PermissionController::class, 'edit'])->middleware('auth');
Route::patch('/permissions/{permission}', [PermissionController::class, 'update'])->middleware('auth');
Route::delete('/permissions/{permission}', [PermissionController::class, 'destroy'])->middleware('auth');
Route::resource('/roles', RoleController::class)->middleware('auth');
Route::resource('/users', UserController::class)->middleware('auth');
Route::get('/my-account', [MyAccountController::class, 'show'])->middleware('auth');
Route::post('/my-account', [MyAccountController::class, 'updateAccount'])->middleware('auth');
Route::post('/my-account/update-password', [MyAccountController::class, 'updatePassword'])->middleware('auth');
