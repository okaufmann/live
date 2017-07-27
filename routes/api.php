<?php

use App\Events\NewMessage;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/send', function (Request $request) {
        $message = $request->message;
        $user = $request->user();

        broadcast(new NewMessage($user, $message));
        return response(201);
    });
});

