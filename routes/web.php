<?php

//
// game submissions
//Route::get('/games', 'FrontEndController@games');// this is moved to another controller

// present
Route::get('/games', 'GameSubmissionController@getFilteredGames');
Route::get('/games/{id}', 'GameSubmissionController@oneGameSubmission');
Route::get('/games/create/{id}', 'FrontEndController@createGameSubmission')->middleware('isLoggedIn', 'isJamDeveloper');
Route::get('/games/{id}/edit', 'FrontEndController@editGameSubmission')->middleware('isLoggedIn', 'isJamDeveloper');
Route::get('/games/{id}/delete', 'GameSubmissionController@delete')->middleware('isLoggedIn', 'isJamDeveloper');

//logic
Route::post('/games/create', 'GameSubmissionController@insert')->middleware('isLoggedIn', 'isJamDeveloper');
Route::post('/games/{id}/edit', 'GameSubmissionController@edit')->middleware('isLoggedIn', 'isJamDeveloper');

//download game file
Route::get('/download/{idDownloadFile}', 'GameSubmissionController@downloadFile')->middleware('isLoggedIn');
//report
Route::post("/report", "GameSubmissionController@report")->middleware('isLoggedIn');


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
Route::get('/game-jams/{id}/join', 'GameJamController@joinUserToGameJam')->middleware('isLoggedIn', 'isJamDeveloper');
Route::get('/game-jams/{id}/leave', 'GameJamController@removeUserFromGameJam')->middleware('isLoggedIn', 'isJamDeveloper');
Route::get('/game-jams/{id}/delete', 'GameJamController@delete')->middleware('isLoggedIn', 'isJamMaker');

//
// profile page
//

// present
Route::get('/profile', 'FrontEndController@profile')->middleware('isLoggedIn');
Route::get('/profile/edit', 'FrontEndController@editProfile')->middleware('isLoggedIn');
Route::get('/user/{username}', 'FrontEndController@getUserProfileInfo')->where('username', '\w+');

Route::get('/user/{username}/game-jams', 'ProfileController@getUsersGameJams')->where('username', '\w+');
Route::get('/user/{username}/games', 'ProfileController@getUsersGames')->where('username', '\w+');
Route::get('/user/{username}/wins', 'ProfileController@getUsersWins')->where('username', '\w+');

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
// admin
//
Route::get("/admin/{page?}", "Admin\AdminController@index")->middleware('isLoggedIn', 'isAdmin');
Route::post("/admin/get-by-id", "Admin\AdminController@getById")->middleware('isLoggedIn', 'isAdmin');
Route::post("/admin/delete", "Admin\AdminController@delete")->middleware("isLoggedIn", "isAdmin");

// update
Route::post("/admin/update/users", "Admin\UpdateController@users")->middleware("isLoggedIn", "isAdmin");
Route::post("/admin/update/game-categories", "Admin\UpdateController@gameCategories")->middleware("isLoggedIn", "isAdmin");
Route::post("/admin/update/game-criteria", "Admin\UpdateController@gameCriteria")->middleware("isLoggedIn", "isAdmin");
Route::post("/admin/update/reports", "Admin\UpdateController@reports")->middleware("isLoggedIn", "isAdmin");
Route::post("/admin/update/roles", "Admin\UpdateController@roles")->middleware("isLoggedIn", "isAdmin");
Route::post("/admin/update/image-categories", "Admin\UpdateController@imageCategories")->middleware("isLoggedIn", "isAdmin");
Route::post("/admin/update/platforms", "Admin\UpdateController@platforms")->middleware("isLoggedIn", "isAdmin");
Route::post("/admin/update/navigations", "Admin\UpdateController@navigations")->middleware("isLoggedIn", "isAdmin");
Route::post("/admin/update/pollquestions", "Admin\UpdateController@pollquestions")->middleware("isLoggedIn", "isAdmin");
Route::post("/admin/update/pollquestions/active", "Admin\UpdateController@setActivePollQuestion")->middleware("isLoggedIn", "isAdmin");
Route::post("/admin/update/pollanswers", "Admin\UpdateController@pollanswers")->middleware("isLoggedIn", "isAdmin");

// insert
Route::post("/admin/insert/users", "Admin\InsertController@users")->middleware("isLoggedIn", "isAdmin");
Route::post("/admin/insert/game-categories", "Admin\InsertController@gameCategories")->middleware("isLoggedIn", "isAdmin");
Route::post("/admin/insert/game-criteria", "Admin\InsertController@gameCriteria")->middleware("isLoggedIn", "isAdmin");
Route::post("/admin/insert/roles", "Admin\InsertController@roles")->middleware("isLoggedIn", "isAdmin");
Route::post("/admin/insert/image-categories", "Admin\InsertController@imageCategories")->middleware("isLoggedIn", "isAdmin");
Route::post("/admin/insert/platforms", "Admin\InsertController@platforms")->middleware("isLoggedIn", "isAdmin");
Route::post("/admin/insert/navigations", "Admin\InsertController@navigations")->middleware("isLoggedIn", "isAdmin");
Route::post("/admin/insert/pollquestions", "Admin\InsertController@pollquestions")->middleware("isLoggedIn", "isAdmin");
Route::post("/admin/insert/pollanswers", "Admin\InsertController@pollanswers")->middleware("isLoggedIn", "isAdmin");

// block
Route::post("/admin/block", "Admin\AdminController@block")->middleware("isLoggedIn", "isAdmin");