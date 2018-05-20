<?php

Route::get('/', 'FrontEndController@gameJams');

Route::get('/games', 'FrontEndController@games');

Route::get('/register', 'FrontEndController@register');
Route::get('/login', 'FrontEndController@login');

Route::get('/about', 'FrontEndController@about');