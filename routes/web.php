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
Route::get('/admin', 'admin\AdminsController@adminDashboard')->name('admin');
Route::prefix('admin')->group(function () {
    Route::get('/login', 'admin\AdminsController@showAdminLoginForm')->name('admin.login');
    Route::get('/order', 'admin\AdminsController@showAdminLoginForm')->name('admin.order.index');
    Route::get('/review', 'admin\AdminsController@showAdminLoginForm')->name('admin.review.index');
    // Route::post('post', 'admin\AdminsController@post');
});