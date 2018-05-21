<?php

//
// game submissions
Route::get('/games', 'FrontEndController@games');
Route::get('/games/create', 'FrontEndController@createGameSubmission');
Route::get('/games/{id}', 'FrontEndController@oneGameSubmission');

//
// game jams
Route::get('/', 'FrontEndController@gameJams');
Route::get('/game-jams/create', 'FrontEndController@createGameJam');
Route::get('/game-jams/{id}', 'FrontEndController@oneGameJam');
Route::get('/game-jams/{id}/edit', 'FrontEndController@editGameJam');

Route::get('/contact-us', 'FrontEndController@contactUs');

//
//auth
Route::get('/register', 'FrontEndController@register');
Route::get('/login', 'FrontEndController@login');


//
//profile
Route::get('/profile', 'FrontendController@profile');
Route::get('/profile/edit', 'FrontendController@editProfile');

//
//other
Route::get('/contact-us', 'FrontEndController@contactUs');
Route::get('/about', 'FrontEndController@about');