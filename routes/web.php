<?php

Route::get('/', 'FrontEndController@gameJams');

Route::get('/games', 'FrontEndController@games');

Route::get('/register', 'FrontEndController@register');