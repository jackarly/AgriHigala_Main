<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/* 
Admin
 */
Route::prefix('admin')->group(function () {
    // ADMIN
    Route::get('/', 'admin\AdminsController@adminDashboard')->name('admin');
    Route::get('/login', 'admin\AdminsController@showAdminLoginForm')->name('admin.login');
    Route::get('/reviews', 'admin\AdminsController@showAdminLoginForm')->name('admin.review.index');

    // USERS
    Route::resource('/users','admin\UsersController', ['names' => 'admin.users']);
    Route::get('/users/create/{id?}', 'admin\UsersController@create')->name('admin.users.create');

    // CATEGORIES:PRODUCT-TYPE
    Route::resource('/categories','admin\ProductTypesController', ['names' => 'admin.categories']);

    // PRODUCTS
    Route::resource('/products','admin\ProductsController', ['names' => 'admin.products']);

    // STOCKS
    Route::resource('/stocks','admin\StocksController', ['names' => 'admin.stocks']);
    Route::get('/stocks/create/{id?}', 'admin\StocksController@create')->name('admin.stocks.create');
    
    // ORDERS
    Route::resource('/orders','admin\OrdersController', ['names' => 'admin.orders']);
    Route::put('/orders/{id}/response', 'admin\OrdersController@sellerOrderRequest')->name('admin.orders.response');
    Route::put('/orders/{id}/packed', 'admin\OrdersController@sellerOrderPending')->name('admin.orders.packed');
    Route::put('/orders/{id}/cancel', 'admin\OrdersController@buyerOrderPending')->name('admin.orders.cancel');
    Route::put('/orders/{id}/delivered', 'admin\OrdersController@riderOrderDelivering')->name('admin.orders.delivered');
    Route::put('/orders/{id}/received', 'admin\OrdersController@buyerOrderDelivered')->name('admin.orders.received');
    
    // RETURN ORDERS
    Route::resource('/returns','admin\ReturnOrdersController', ['names' => 'admin.returns']);
    Route::put('/returns/{id}/response', 'admin\ReturnOrdersController@sellerReturnRequest')->name('admin.returns.response');
    Route::put('/returns/{id}/delivered', 'admin\ReturnOrdersController@riderReturnDelivering')->name('admin.returns.delivered');

    // HISTORY ORDERS
    Route::resource('/history','admin\HistoryController', ['names' => 'admin.history']);

});