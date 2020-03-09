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

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/about', 'AboutController@index')->name('about');
Route::get('/about/{name}', 'AboutController@show')->name('about.show');

Route::get('/token', function (Request $request) {
    $http = new GuzzleHttp\Client;

    $response = $http->post('http://localhost:8000/oauth/token', [
        'form_params' => [
            'grant_type' => 'password',
            'client_id' => '22c109fe-5017-45c1-b208-5178552de2b2',
            'client_secret' => 'HJhycuZ5RMV0BR6BP3y9vWNplWKLrypVXdqenaly',
            'email' => input('email'),
            'password' => input('password'),
            'scope' => '',
        ],
    ]);

    return json_decode((string) $response->getBody(), true);
});
