<?php

Route::group(['prefix' => '/a-s', 'middleware' => ['web']], function () {
    Route::get('/p/{affiliate_token}', '\KeithBrink\AffiliatesSpark\Http\Controllers\AffiliateController@link');
    Route::get('/s/{affiliate_token}', '\KeithBrink\AffiliatesSpark\Http\Controllers\AffiliateController@setCookie');
    Route::get('/p-s', '\KeithBrink\AffiliatesSpark\Http\Controllers\AffiliateController@showCookie');
    Route::get('/aff.js', '\KeithBrink\AffiliatesSpark\Http\Controllers\AffiliateController@getJavascript');
});

Route::group(['prefix' => 'affiliates', 'middleware' => ['web', 'auth', 'affiliates-spark-affiliate']], function () {
    Route::get('/', '\KeithBrink\AffiliatesSpark\Http\Controllers\AffiliateController@index');
    Route::get('/transactions', '\KeithBrink\AffiliatesSpark\Http\Controllers\AffiliateController@getTransactions');
    Route::get('/withdraw', '\KeithBrink\AffiliatesSpark\Http\Controllers\AffiliateController@getWithdraw');
    Route::post('/withdraw', '\KeithBrink\AffiliatesSpark\Http\Controllers\AffiliateController@postWithdraw');
});

Route::group(['prefix' => '/affiliates-spark/kiosk/affiliates', 'middleware' => ['web', 'auth', 'dev']], function () {
    Route::get('/', '\KeithBrink\AffiliatesSpark\Http\Controllers\KioskAffiliatesController@getAffiliates');
    Route::get('/plans', '\KeithBrink\AffiliatesSpark\Http\Controllers\KioskAffiliatesController@getPlans');
    Route::get('/add', '\KeithBrink\AffiliatesSpark\Http\Controllers\KioskAffiliatesController@getAddAffiliate');

    Route::post('/add', '\KeithBrink\AffiliatesSpark\Http\Controllers\KioskAffiliatesController@postAddAffiliate');
    Route::post('/plans/add', '\KeithBrink\AffiliatesSpark\Http\Controllers\KioskAffiliatesController@postAddPlan');
});