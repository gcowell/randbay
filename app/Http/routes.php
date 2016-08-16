<?php

//Home routes...
Route::get('/', 'PagesController@index');
Route::get('/home', 'HomeController@index');
Route::get('/how', 'PagesController@how');
Route::get('/faq', 'PagesController@FAQ');
Route::get('/rules', 'PagesController@rules');
Route::get('/tips', 'PagesController@tips');



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
Route::post('saleitems/rate/{id}', 'SaleitemsController@rate');
Route::post('saleitems/{id}', 'SaleitemsController@update');
Route::post('saleitems', 'SaleitemsController@store');

Route::get('saleitems/transaction/{id}', 'SaleitemsController@showSaleItemTransaction');
Route::get('saleitems/create', 'SaleitemsController@create');
Route::get('saleitems/rand', 'SaleitemsController@returnRandomItems');
Route::get('saleitems/{id}', 'SaleitemsController@show');
Route::get('saleitems', 'SaleitemsController@index');



Route::delete('saleitems/{id}', 'SaleitemsController@destroy');


//Buy Order routes
Route::get('buyorders', 'BuyOrdersController@index');
Route::get('buyorders/create', 'BuyOrdersController@create');
Route::get('buyorders/redo/{id}', 'BuyOrdersController@redo');
Route::post('buyorders', 'BuyOrdersController@find');

//Transactions routes
Route::get('transactions', 'TransactionsController@index');
Route::post('transactions', 'TransactionsController@create');
Route::get('transactions/{id}', 'TransactionsController@show');
Route::put('transactions/{id}', 'TransactionsController@update');
Route::get('transactions/support/{id}', 'TransactionsController@showTransactionTicket');



// this is after make the payment, PayPal redirect back to your site
Route::get('transactions/payment/status', array(
    'as' => 'payment.status',
    'uses' => 'TransactionsController@getPaymentStatus',
));

//Images routes
Route::get('images/{filename}', function ($filename)
{
    $path = storage_path() . '\\items\\' . $filename;
    $file = File::get($path);
    $type = File::mimeType($path);
    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});



//Evidence routes
Route::get('evidence/{dir}/{file}', function ($dir, $file)
{
    $path = storage_path() . '\\tickets\\' . $dir . '\\' . $file;
    $file = File::get($path);
    $type = File::mimeType($path);
    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});


//Notification Routes
Route::get('notifications', 'NotificationsController@index');
Route::get('notifications/read/{id}', 'NotificationsController@markAsRead');
Route::get('notifications/check', 'NotificationsController@checkForNew');

//Support routes
Route::get('support', 'SupportTicketController@index');
Route::get('support/complaints', 'SupportTicketController@complaints');
Route::get('support/create/{id}', 'SupportTicketController@createTicket');
Route::get('support/{id}', 'SupportTicketController@show');

Route::post('support', 'SupportTicketController@store');
Route::post('support/evidence/{id}', 'SupportTicketController@addEvidence');


//Administrative Routes
Route::get('johnpupperman', 'AdminController@index');
Route::get('johnpupperman/saleitems', 'AdminController@saleitemsMonitoring');
Route::get('johnpupperman/tickets', 'AdminController@supportTicketMonitoring');
Route::get('johnpupperman/users', 'AdminController@userList');


//TODO REMOVE!
/////////////////////////////////////////////////////////////////////////////
//TEMPORARY Currency Routes
Route::get('currencies', 'TempCurrencyController@getRate');

//TEMPORARY Mail Routes
Route::get('mail', 'TempMailController@sendMail');








