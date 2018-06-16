<?php

//
// game submissions
//Route::get('/games', 'FrontEndController@games');// this is moved to another controller
Route::get('/games', 'GameSubmissionController@getFilteredGames');
Route::get('/games/create/{id}', 'FrontEndController@createGameSubmission')->middleware('isLoggedIn', 'isJamDeveloper');
Route::get('/games/{id}', 'GameSubmissionController@oneGameSubmission');
Route::get('/games/{id}/edit', 'FrontEndController@editGameSubmission')->middleware('isLoggedIn', 'isJamDeveloper');

//
// game jams
//

// present
Route::get('/', 'FrontEndController@gameJams');
Route::get('/game-jams/create', 'FrontEndController@createGameJam')->middleware('isLoggedIn', 'isJamMaker');
Route::get('/game-jams/{id}', 'FrontEndController@oneGameJam');
Route::get('/game-jams/{id}/edit', 'FrontEndController@editGameJam')->middleware('isLoggedIn', 'isJamMaker');

// logic
Route::post('/game-jams/create', 'GameJamController@insert')->middleware('isLoggedIn', 'isJamMaker');
Route::post('/game-jams/edit', 'GameJamController@update')->middleware('isLoggedIn', 'isJamMaker');
Route::post('/game-jams/join', 'GameJamController@joinUser')->middleware('isLoggedIn', 'isJamDeveloper');


//
// profile page
//

// present
Route::get('/profile', 'FrontEndController@profile')->middleware('isLoggedIn');
Route::get('/profile/edit', 'FrontEndController@editProfile')->middleware('isLoggedIn');
Route::get('/user/{username}', 'FrontEndController@getUserProfileInfo')->where('username', '\w+');

// logic
Route::post('/profile/edit', 'ProfileController@edit')->middleware('isLoggedIn');


//
// about page
Route::get('/about', 'FrontEndController@about');


//
// Contact us page

// present
Route::get('/contact-us', 'FrontEndController@contactUs');

// logic
Route::post('/pollVote', 'ContactUsController@pollVote')->middleware('isLoggedIn');
Route::post('/contact-us', 'ContactUsController@postContact');


//
// Search
//

//present
Route::get('/search', 'SearchController@search');


//
// auth
//

// present
Route::get('/register', 'FrontEndController@register')->middleware('isNotLoggedIn');
Route::get('/login', 'FrontEndController@login')->middleware('isNotLoggedIn');

// logic
Route::get("/logout", "AuthController@logout")->middleware('isLoggedIn');
Route::post("/login", "AuthController@login")->middleware('isNotLoggedIn');
Route::post("/register", "AuthController@register")->middleware('isNotLoggedIn');



//
// admin stuff
//
Route::get("/admin", "AdminController@index")->middleware('isLoggedIn', 'isAdmin');

