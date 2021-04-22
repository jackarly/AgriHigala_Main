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

// Admin
Route::prefix('admin')->group(function () {
    Route::get('/', 'admin\AdminsController@adminDashboard')->name('admin');
    Route::get('/login', 'admin\AdminsController@showAdminLoginForm')->name('admin.login');
    Route::get('/orders', 'admin\AdminsController@showAdminLoginForm')->name('admin.order.index');
    Route::get('/reviews', 'admin\AdminsController@showAdminLoginForm')->name('admin.review.index');

    Route::resource('/users','admin\UsersController', ['names' => 'admin.users']);
    Route::get('/users/create/{id?}', 'admin\UsersController@create')->name('admin.users.create');

    Route::resource('/categories','admin\ProductTypesController', ['names' => 'admin.categories']);
    Route::resource('/products','admin\ProductsController', ['names' => 'admin.products']);
    Route::resource('/stocks','admin\StocksController', ['names' => 'admin.stocks']);
    Route::get('/stocks/create/{id?}', 'admin\StocksController@create')->name('admin.stocks.create');

});