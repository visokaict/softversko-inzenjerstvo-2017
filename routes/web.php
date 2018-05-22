<?php

//
//game jams
Route::get('/', 'FrontEndController@gameJams');

//
// game submissions
Route::get('/games', 'FrontEndController@games');
Route::get('/games/create', 'FrontEndController@createGameSubmission');
Route::get('/games/{id}', 'FrontEndController@oneGameSubmission');
Route::get('/games/{id}/edit', 'FrontEndController@editGameSubmission');

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


//
//admin stuff
Route::get("/admin", "AdminController@index");