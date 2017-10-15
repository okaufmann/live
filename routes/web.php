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

// Authentication Routes...
//$this->get('login', 'Auth\RegisterController@showLoginForm')->name('login');
//$this->post('login', 'Auth\LoginController@login');
$this->get('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
$this->get('login', 'Auth\RegisterController@showRegistrationForm')->name('login');
$this->post('register', 'Auth\RegisterController@register')->name('register');

// Password Reset Routes...
//$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
//$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
//$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
//$this->post('password/reset', 'Auth\ResetPasswordController@reset');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

    Route::get('event/{events?}', function (\Illuminate\Http\Request $request) {
        if ($request->events) {
            $events = (int)$request->events;
            $events = $events > 100 ? 100 : $events;

            for ($i = 0; $i < $events; $i++) {
                broadcast(new \App\Events\HelloEvent('hello'));
            }
        } else {
            broadcast(new \App\Events\HelloEvent('hello'));
        }
    });

});

