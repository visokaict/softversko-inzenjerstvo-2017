<?php

Route::get('/', 'FrontEndController@gameJams');

//
// game submissions
Route::get('/games', 'FrontEndController@games');
Route::get('/games/create', 'FrontEndController@createGameSubmission');


Route::get('/contact-us', 'FrontEndController@contactUs');

Route::get('/register', 'FrontEndController@register');
Route::get('/login', 'FrontEndController@login');

Route::get('/about', 'FrontEndController@about');

Route::get('/profile', 'FrontendController@profile');