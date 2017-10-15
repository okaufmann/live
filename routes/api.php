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

    Route::get('/server_status', function (Request $request) {
        //http://localhost:6001/apps/undefined/status?auth_key=undefined
        $host = config('broadcasting.connections.pusher.options.host');
        $port = config('broadcasting.connections.pusher.options.port');
        $port = $port ? ':'.$port : '';
        $encrypted = config('broadcasting.connections.pusher.options.encrypted');
        $protocol = $encrypted ? 'https://' : 'http://';
        $appId = config('services.echo_server.app_id');
        $appKey = config('services.echo_server.app_key');

        $url = $protocol.$host.$port.'/apps/'.$appId.'/status?auth_key='.$appKey;

        $client = new \GuzzleHttp\Client();
        $response = $client->get($url, ['connect_timeout' => 1]);

        return response((string)$response->getBody());
    });
});

