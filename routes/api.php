
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

Route::group(['prefix' => 'auth'], function () {
    //register new user (Organization Owner)
    Route::post('/wizard/newUser', 'AuthController@newUserWizard');
    //user login
    Route::post('/login', 'AuthController@login');
    //user logout
    Route::post('/logout', 'AuthController@logout');
    //user reset password
    Route::post('/resetPassword', 'AuthController@resetPassword');
    //user confirm code after registeration
    Route::post('/conf', 'AuthController@confirmation');
    //invite members by mail
    Route::post('/wizard/invitation', 'AuthController@invitationWizard');
    //not completed
    Route::post('/wizard/updateUser', 'AuthController@updateUserWizard');

//    Route::get('notifications', 'AuthController@notifications');
});

Route::resource('orders', 'OrderAPIController');

Route::resource('products', 'productsAPIController');

Route::resource('pre_orders', 'Pre_orderAPIController');

Route::resource('stores', 'StoreAPIController');