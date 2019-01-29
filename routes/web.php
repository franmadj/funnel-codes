<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */


$router->put('/settings/contact', 'Spark\ContactInformationController@update');
$router->post('/register', 'Auth\RegisterController@register');

Route::get('/', 'WelcomeController@show');

Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => 'api'], function () {
        \App\Http\Controllers\API\FunnelController::Routes();
        \App\Http\Controllers\API\TagController::Routes();
        \App\Http\Controllers\API\CouponBankController::Routes();
        \App\Http\Controllers\API\CouponCodeController::Routes();
        \App\Http\Controllers\API\CouponFieldController::Routes();
    });


    Route::get('/home', 'FunnelController@index');
    Route::get('/tags', 'TagController@index');
    Route::get('/funnel/{funnel}', 'CouponBankController@index')->middleware('can:view,funnel');
    Route::get('/coupon-codes/{couponBank}', 'CouponCodeController@index')->middleware('can:view,couponBank');
    Route::get('/coupon-codes/export/{couponBank}', 'CouponCodeController@export')->middleware('can:view,couponBank');
    Route::get('/coupon-fields/{couponBank}', 'CouponCodeController@fields')->middleware('can:view,couponBank');
    Route::get('/coupon-redemption/{couponBank}', 'CouponBankController@redemption');
    
    //Route::resource('/funnels', 'FunnelController');
    //Route::resource('/tags', 'TagController');
});




