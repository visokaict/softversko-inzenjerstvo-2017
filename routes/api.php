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

//game submission comments
Route::get('/games/{gameId}/comments', 'GameSubmissionCommentController@get');
Route::post('/games/{gameId}/comments', 'GameSubmissionCommentController@add')->middleware('canAccessApi');
Route::patch('/games/{gameId}/comments/{commentId}', 'GameSubmissionCommentController@edit')->middleware('canAccessApi');
Route::delete('/games/{gameId}/comments/{commentId}', 'GameSubmissionCommentController@remove')->middleware('canAccessApi');

//statistics for admin site
Route::get('/admin/statistics/chart/all', 'Admin\StatisticsController@getAllChart');
Route::get('/admin/statistics/count/all', 'Admin\StatisticsController@getAllCount');
