<?php

//Home routes...
Route::get('/', 'PagesController@index');
Route::get('/home', 'HomeController@index');

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

//User routes
Route::get('users/dashboard', 'UserController@index');
Route::get('users/{id}', 'UserController@show');


//Sale Item routes
Route::get('saleitems', 'SaleitemsController@index');
Route::get('saleitems/create', 'SaleitemsController@create');
Route::post('saleitems', 'SaleitemsController@store');
Route::get('saleitems/{id}', 'SaleitemsController@show');

//Sale Item routes
Route::get('buyorders', 'BuyOrdersController@index');
Route::get('buyorders/create', 'BuyOrdersController@create');
Route::post('buyorders', 'BuyOrdersController@find');
Route::get('buyorders/{id}', 'BuyOrdersController@show');






