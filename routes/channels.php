<?php
use App\Events\BroadcastingDemo;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

//Broadcast::channel('App.User.{id}', function ($user, $id) {
 //   return (int) $user->id === (int) $id;
//});


Route::get('fire', function () {
    // this fires the event
    $dashboardData = ['data'=>'data you wan to pass on channel'];
    event(new BroadcastingDemo($dashboardData));
    

    //$redis=Redis::connect('127.0.0.1',6379);
    return response('redis working');
});
