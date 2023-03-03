<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index')->name('home');
Route::get('/about', 'HomeController@about')->name('about');
Route::get('/product/filter', 'HomeController@filter')->name('filter');


Auth::routes(['verify' => true]);

Route::group(['prefix' => 'customer', 'as' => 'customer.', 'namespace' => 'Customer', 'middleware' => ['auth','verified']], function () {
    Route::get('/approve', function() {
           return view('auth.checkapprove');
         });
 });



Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    // Dashboard
    Route::get('dashboard', 'HomeController@index')->name('dashboard');

    // Inventories
    Route::resource('products', 'ProductController');
    Route::post('products/update/{product}', 'ProductController@updateproduct')->name('products.updateproduct');
    Route::post('products/stock/{product}', 'ProductController@addedstock')->name('products.addedproduct');

    // Orders
    Route::get('orders', 'OrderController@orders')->name('orders');

    // Change Status
    Route::put('orders/status/{order}', 'OrderController@status')->name('orders.status');

    // receipt
    Route::get('orders/receipt/{order}', 'OrderController@receipt')->name('orders.receipt');

    // receipt
    Route::get('orders/receipt/{order}', 'OrderController@receipt')->name('orders.receipt');

    // Sales Reports
    Route::get('sales_reports/{filter}/{from}/{to}', 'OrderController@sales_reports')->name('sales_reports');
    

     // CustomerList
     Route::get('customer_list', 'CustomerListController@index')->name('customer');
     Route::get('customer_list/{user}/edit', 'CustomerListController@edit')->name('customer.edit');
     Route::get('customer_list/{user}/status', 'CustomerListController@status')->name('customer.status');

     Route::put('customer_list/{user}', 'CustomerListController@update')->name('customer.update');
     Route::put('customer_list/{user}/dpass', 'CustomerListController@defaultPassowrd')->name('customer.dpass');

     // Admin List
     Route::get('staff_list', 'CustomerListController@staff_index')->name('staff');
     Route::post('staff_list', 'CustomerListController@staff_store')->name('staff.store');
     Route::put('staff_list/{staff}', 'CustomerListController@staff_update')->name('staff.update');

     // Change Status
     Route::put('customer/status/{user}', 'CustomerListController@status')->name('customer.status12');
    
     // Categories
     Route::resource('categories', 'CategoryController');

     // fees
     Route::resource('fees', 'ShippingFeeController');

     
    Route::get('styles', 'LayoutStyleController@index')->name('styles.index');
    Route::post('styles', 'LayoutStyleController@update')->name('styles.update');
     
});


Route::group(['prefix' => 'customer', 'as' => 'customer.', 'namespace' => 'Customer', 'middleware' => ['auth','checkapproved','verified']], function () {
    
    // ORDERS
    Route::get('product/{product}', 'OrderController@view')->name('product.view');
    Route::post('product/{product}', 'OrderController@order')->name('product.order');
    Route::get('orders', 'OrderController@orders')->name('orders.index');
    Route::get('orders/{order}/edit', 'OrderController@edit')->name('order.edit');
    Route::put('orders/{order}', 'OrderController@update')->name('order.update');
    Route::delete('orders/{order}', 'OrderController@cancel')->name('order.cancel');
    Route::post('orders/checkout', 'OrderController@checkout')->name('order.checkout');

    // ORDER HISTORY
    Route::get('orders_history', 'OrderController@orders_history')->name('orders.history');
    Route::post('orders/cancel/{order}', 'OrderController@cancel_order')->name('orders.cancel');

    // ACCOUNT
    Route::get('account', 'HomeController@account')->name('account');
    Route::put('account', 'HomeController@account_update')->name('account.update');
    Route::put('account/change_password/{user}', 'HomeController@passwordupdate')->name('account.passwordupdate');

    // REVIEW ORDER HISTORY
    // STORE REVIEW
    Route::get('review', 'ReviewController@review')->name('review.review');

    
   
});