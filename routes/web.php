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
    return view('home');
});


Auth::routes();

Route::get('/home', 'HomeController@index');

Route::resource('orders', 'OrderController');

Route::resource('products', 'productsController');

Route::resource('stores', 'StoreController');

Route::resource('users', 'UserController');

Route::get('/store/{id}/products', 'StoreController@products');


Route::post('/save', 'preOrderController@saveOrder')->name('saveOrder');
Route::get('/preOrders/confirmation', 'preOrderController@confirmation');
Route::get('/user/orders', 'OrderController@userOrders');

