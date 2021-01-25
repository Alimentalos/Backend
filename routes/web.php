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

Route::view('/', 'welcome')->name('welcome');
Route::view('/home', 'HomeController@index')->name('home');
Route::view('/map', 'map')->name('map');
Route::view('/profile', 'profile')->name('profile');

Route::middleware('guest')->group(function () {
    Route::view('login', 'auth.login')->name('login');
    Route::view('register', 'auth.register')->name('register');
});

Route::view('password/reset', 'auth.passwords.email')->name('password.request');
Route::get('password/reset/{token}', 'Auth\PasswordResetController')->name('password.reset');

Route::middleware('auth')->group(function () {
    Route::view('email/verify', 'auth.verify')->middleware('throttle:6,1')->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', 'Auth\EmailVerificationController')->middleware('signed')->name('verification.verify');

    Route::post('logout', 'Auth\LogoutController')->name('logout');

    Route::view('password/confirm', 'auth.passwords.confirm')->name('password.confirm');
});

/**
 * Authenticated and verified routes ...
 */
Route::middleware(['auth'])->group(function () {
	foreach (config('resources.listable') as $key => $resource) {
		Route::get("/{$key}", 'Resource\IndexController')
			->name("web.{$key}.index");
	}

	foreach(config('resources.storable') as $key => $resource) {
		Route::get("/{$key}/create", 'Resource\CreateController')
			->name("web.{$key}.create");
	}

	foreach(config('resources.viewable') as $key => $resource) {
		Route::get("/{$key}/{resource}", 'Resource\ShowController')
			->name("web.{$key}.show");
	}

	foreach(config('resources.modifiable') as $key => $resource) {
		Route::get("/{$key}/{resource}/edit", 'Resource\EditController')
			->name("web.{$key}.edit");
	}
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
