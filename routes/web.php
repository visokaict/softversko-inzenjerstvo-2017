<?php

//
// game submissions
Route::get('/games', 'FrontEndController@games');
Route::get('/games/create', 'FrontEndController@createGameSubmission');
Route::get('/games/{id}', 'FrontEndController@oneGameSubmission');
Route::get('/games/{id}/edit', 'FrontEndController@editGameSubmission');

//
// game jams
Route::get('/', 'FrontEndController@gameJams');
Route::get('/game-jams/create', 'FrontEndController@createGameJam');
Route::get('/game-jams/{id}', 'FrontEndController@oneGameJam');
Route::get('/game-jams/{id}/edit', 'FrontEndController@editGameJam');

Route::get('/contact-us', 'FrontEndController@contactUs');

//
// game jams
Route::get('/', 'FrontEndController@gameJams');
Route::get('/game-jams/create', 'FrontEndController@createGameJam');
Route::get('/game-jams/{id}', 'FrontEndController@oneGameJam');
Route::get('/game-jams/{id}/edit', 'FrontEndController@editGameJam');

Route::get('/contact-us', 'FrontEndController@contactUs');

//
// login, register
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


//
//admin stuff
Route::get("/admin", "AdminController@index");


// auth 
Route::post("/login", "AuthController@login");
Route::get("/logout", "AuthController@logout");
