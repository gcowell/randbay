<?php

//Page routes...
Route::get('/', 'PagesController@index');
Route::get('/home', 'HomeController@index');
Route::get('/how', 'PagesController@how');
Route::get('/faq', 'PagesController@FAQ');
Route::get('/rules', 'PagesController@rules');
Route::get('/tips', 'PagesController@tips');

//Contact routes...
Route::get('/contact', 'ContactController@create');
Route::post('/contact', 'ContactController@send');


// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');


//Sale Item routes
Route::post('saleitems', 'SaleitemsController@store');

Route::get('saleitems/create', 'SaleitemsController@create');
Route::get('saleitems/rand', 'SaleitemsController@returnRandomItems');


//Buy Order routes
Route::get('buyorders', 'BuyOrdersController@index');
Route::get('buyorders/create', 'BuyOrdersController@create');
Route::get('buyorders/redo/{id}', 'BuyOrdersController@redo');
Route::post('buyorders', 'BuyOrdersController@find');

//Transactions routes
Route::post('transactions', 'TransactionsController@create');



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


//Administrative Routes
Route::get('johnpupperman', 'AdminController@index');
Route::get('johnpupperman/saleitems', 'AdminController@saleitemsMonitoring');
Route::post('johnpupperman/saleitems', 'AdminController@markAsChecked');
Route::get('johnpupperman/saleitems/delete/{id}', 'AdminController@adminDelete');


//Mailing List Routes
Route::get('mailinglist', 'MailingListController@index');
Route::get('mailinglist/{id}', 'MailingListController@confirm');
Route::post('mailinglist', 'MailingListController@unsubscribe');



//TODO DEPLOY - REMOVE!
/////////////////////////////////////////////////////////////////////////////
//TEMPORARY Currency Routes
Route::get('currencies', 'TempCurrencyController@getRate');

//TEMPORARY Mail Routes
Route::get('mail', 'TempMailController@sendMail');








