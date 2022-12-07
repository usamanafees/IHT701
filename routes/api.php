<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::any('wp_notify_sms', 'API\SMSController@wp_notify_sms');
Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');
Route::group(['middleware' => 'verifyapimiddleware'], function(){
// Route::group(['middleware' => 'auth:api'], function(){
    
    // User Api Routes
    Route::post('details', 'API\UserController@details');
    
    // Items Api Routes
    Route::get('/getItem/{id}', 'API\ItemsController@getItem');
    Route::get('/getItemByCode/{code}', 'API\ItemsController@getItemByCode');
    Route::get('/getItems', 'API\ItemsController@getItems');
    Route::post('/addItem', 'API\ItemsController@addItem');
    Route::put('/updateItem/{id}', 'API\ItemsController@updateItem');
    Route::delete('/deleteItem/{id}', 'API\ItemsController@deleteItem');
    
    // Cients Api Routes
    Route::get('/getClients', 'API\ClientsController@getClients');
    Route::get('/getClient/{id}', 'API\ClientsController@getClient');
    Route::post('/addClient', 'API\ClientsController@addClient');
    Route::put('/updateClient/{id}', 'API\ClientsController@updateClient');
    Route::delete('/deleteClient/{id}', 'API\ClientsController@deleteClient');
    
    // Invoices Api Routes
    Route::get('/getInvoices', 'API\InvoicesController@getInvoices');
    Route::get('/getInvoice/{id}', 'API\InvoicesController@getInvoice');
    Route::post('/addInvoice', 'API\InvoicesController@addInvoice');
    // Route::post('/addInvoiceWithLineItems', 'API\InvoicesController@addInvoiceWithLineItems');
    Route::put('/updateInvoice/{id}', 'API\InvoicesController@updateInvoice');
    Route::delete('/deleteInvoice/{id}', 'API\InvoicesController@deleteInvoice');
    
    // Invoice Line Items
    // Route::get('/getLineItems', 'API\LineItemsController@getLineItems');
    // Route::get('/getLineItem/{id}', 'API\LineItemsController@getLineItem');
    // Route::post('/addLineItem', 'API\LineItemsController@addLineItem');
    // Route::put('/updateLineItem/{id}', 'API\LineItemsController@updateLineItem');
    // Route::delete('/deleteLineItem/{id}', 'API\LineItemsController@deleteLineItem');

    //SMS Api Routes
    Route::post('/addSMS', 'API\SMSController@addSMS');
	
	Route::get('eupago_callback/','SMSController@eupago_callback')->name('eupago_callback');
	


});
