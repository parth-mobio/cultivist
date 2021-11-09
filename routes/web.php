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
/*
<<<<<<< HEAD
Route::get('/sdsd', function () {
    return view('thank_you');
}); // test
*/

Route::get('/','TestController@index');
Route::post('individual-post','TestController@individual');
Route::post('individual_checkout','TestController@individual_checkout');
Route::post('dual-post','TestController@dual');
Route::post('dual_checkout','TestController@dual_checkout');
Route::post('coupen_check','TestController@check_coupen');
Route::post('gifting','TestController@gifting');
Route::post('gift_checkout','TestController@gift_checkout');
Route::get('success','TestController@success');
Route::post('form-submit','TestController@formsubmit');

// webhook routes
Route::post('stripe/webhook', 'StripeWebhookController@handleWebhook');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Route::get('admin','Admin\UserController@home');
Route::get('users', 'Admin\UserController@index');
Route::get('users-add', 'Admin\UserController@add');
Route::post('users-add', 'Admin\UserController@Insert');
Route::get('users-edit/{slug}', 'Admin\UserController@update');
Route::post('users-edit/{slug}', 'Admin\UserController@Update_');
Route::get('users-remove/{slug}', 'Admin\UserController@Remove');
Route::get('my-profile/{slug}','Admin\UserController@my_profile');
Route::post('user-status-update', 'Admin\UserController@updateStatus');
Route::get('change_password/{slug}','Admin\UserController@change_password');
Route::post('update_password/{slug}','Admin\UserController@update_password');

Route::get('customer', 'customerController@index');
Route::get('customer-add', 'customerController@add');
Route::post('customer-add', 'customerController@Insert');
Route::get('customer-edit/{slug}', 'customerController@edit');
Route::post('customer-edit/{slug}', 'customerController@Update_');
Route::post('customer-status-update', 'customerController@updateStatus');
Route::get('customer-remove/{slug}', 'customerController@destroy');
