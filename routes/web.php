<?php

//
// game submissions
Route::get('/games', 'FrontEndController@games');
Route::get('/games/create', 'FrontEndController@createGameSubmission')->middleware('isLoggedIn', 'isJamDeveloper');
Route::get('/games/{id}', 'FrontEndController@oneGameSubmission');
Route::get('/games/{id}/edit', 'FrontEndController@editGameSubmission')->middleware('isLoggedIn', 'isJamDeveloper');

//
// game jams
Route::get('/', 'FrontEndController@gameJams');
Route::get('/game-jams/create', 'FrontEndController@createGameJam')->middleware('isLoggedIn', 'isJamMaker');
Route::get('/game-jams/{id}', 'FrontEndController@oneGameJam');
Route::get('/game-jams/{id}/edit', 'FrontEndController@editGameJam')->middleware('isLoggedIn', 'isJamMaker');

Route::post('/game-jams/create', 'GameJamController@insert')->middleware('isLoggedIn', 'isJamMaker');


//
// login, register
Route::get('/register', 'FrontEndController@register')->middleware('isNotLoggedIn');
Route::get('/login', 'FrontEndController@login')->middleware('isNotLoggedIn');


//
//profile
Route::get('/profile', 'FrontEndController@profile')->middleware('isLoggedIn');
Route::get('/profile/edit', 'FrontEndController@editProfile')->middleware('isLoggedIn');
Route::get('/user/{username}', 'FrontEndController@getUserProfileInfo')->where('username', '\w+');

Route::post('/profile/edit', 'ProfileController@edit')->middleware('isLoggedIn');

//
//other
Route::get('/contact-us', 'FrontEndController@contactUs');
Route::post('/contact-us', 'ContactUsController@postContact');

Route::get('/about', 'FrontEndController@about');

//
// Contact us page stuff
Route::post('/pollVote', 'ContactUsController@pollVote')->middleware('isLoggedIn');


//
//admin stuff
Route::get("/admin", "AdminController@index")->middleware('isLoggedIn', 'isAdmin');


//
// auth
Route::post("/login", "AuthController@login")->middleware('isNotLoggedIn');
Route::get("/logout", "AuthController@logout")->middleware('isLoggedIn');
Route::post("/register", "AuthController@register")->middleware('isNotLoggedIn');