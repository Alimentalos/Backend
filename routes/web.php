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

use Illuminate\Http\Request;

Route::get('/', 'WelcomeController');

Route::get('/home', 'HomeController@index')->name('home');


Route::get('/lang/{lang}', function(Request $request) {
    if (!in_array($request->route('lang'), ['es', 'en'])) {
        throw new Exception('Unsupported language');
    }
    \Illuminate\Support\Facades\Session::put('lang', $request->route('lang'));
    return redirect()->back();
})->name('lang');

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/about', 'AboutController@index')->name('about');
Route::get('/about/{name}', 'AboutController@show')->name('about.show');
Route::get('/about/{name}/{page}', 'AboutController@view')->name('about.view');
