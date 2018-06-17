<?php

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


/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

// game jams
Route::get('/game-jams/chart', 'GameJamController@getChartGameJams');

// Bages
Route::get('/games/{gameId}/badges', 'BadgesController@get');
Route::post('/games/{gameId}/badges/{badgeId}', 'BadgesController@add')->middleware('canAccessApi');
Route::delete('/games/{gameId}/badges/{badgeId}', 'BadgesController@remove')->middleware('canAccessApi');
