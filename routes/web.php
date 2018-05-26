<?php

//
// game submissions
Route::get('/games', 'FrontEndController@games');
Route::get('/games/create', 'FrontEndController@createGameSubmission')->middleware('isLoggedIn');
Route::get('/games/{id}', 'FrontEndController@oneGameSubmission');
Route::get('/games/{id}/edit', 'FrontEndController@editGameSubmission')->middleware('isLoggedIn');

//
// game jams
Route::get('/', 'FrontEndController@gameJams');
Route::get('/game-jams/create', 'FrontEndController@createGameJam')->middleware('isLoggedIn');
Route::get('/game-jams/{id}', 'FrontEndController@oneGameJam');
Route::get('/game-jams/{id}/edit', 'FrontEndController@editGameJam')->middleware('isLoggedIn');

Route::post('/game-jams/create', 'GameJamController@insert');

Route::get('/contact-us', 'FrontEndController@contactUs');


//
// login, register
Route::get('/register', 'FrontEndController@register')->middleware('isNotLoggedIn');
Route::get('/login', 'FrontEndController@login')->middleware('isNotLoggedIn');


//
//profile
Route::get('/profile', 'FrontendController@profile')->middleware('isLoggedIn');
Route::get('/profile/edit', 'FrontendController@editProfile')->middleware('isLoggedIn');

//
//other
Route::get('/contact-us', 'FrontEndController@contactUs');
Route::get('/about', 'FrontEndController@about');


//
//admin stuff
Route::get("/admin", "AdminController@index")->middleware('isLoggedIn', 'isAdmin');


//
// auth
Route::post("/login", "AuthController@login")->middleware('isNotLoggedIn');
Route::get("/logout", "AuthController@logout")->middleware('isLoggedIn');
Route::post("/register", "AuthController@register")->middleware('isNotLoggedIn');