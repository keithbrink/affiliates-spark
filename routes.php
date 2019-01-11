<?php

Route::get('/p/{affiliate_token}', '\KeithBrink\AffiliatesSpark\Http\Controllers\AffiliateController@link');
Route::get('/s/{affiliate_token}', '\KeithBrink\AffiliatesSpark\Http\Controllers\AffiliateController@setCookie');
Route::get('/p-s', '\KeithBrink\AffiliatesSpark\Http\Controllers\AffiliateController@showCookie');

Route::group(['middleware' => ['web', 'auth']], function () {    
    Route::group(['prefix' => 'affiliates', 'middleware' => 'affiliates-spark-affiliate'], function () {
        Route::get('/', '\KeithBrink\AffiliatesSpark\Http\Controllers\AffiliateController@index');
        Route::get('/transactions', '\KeithBrink\AffiliatesSpark\Http\Controllers\AffiliateController@getTransactions');
        Route::get('/withdraw', '\KeithBrink\AffiliatesSpark\Http\Controllers\AffiliateController@getWithdraw');
        Route::post('/withdraw', '\KeithBrink\AffiliatesSpark\Http\Controllers\AffiliateController@postWithdraw');
    });
});

Route::get('/affiliates-spark/kiosk/affiliates', '\KeithBrink\AffiliatesSpark\Http\Controllers\KioskAffiliatesController@index');
