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

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/sendMoney', 'HomeController@sendMoney')->name('sendMoney');

//setting
Route::post('/addPromoCode', 'HomeController@addPromoCode')->name('addPromoCode');
Route::get('/promoCode', 'HomeController@getPromoCode')->name('getPromoCode');
Route::post('/redeemCode','HomeController@redeemCode')->name('redeemCode');
Route::get('/allUser', 'SettingController@allUser')->name('allUser');
Route::post('/editUser', 'SettingController@editUser')->name('editUser');
Route::get('getUserAjax/{id}', 'SettingController@getUserAjax')->name('getUserAjax');

//qr
Route::get('/qrCode', function () {
    return view('qrCode');
});


//register
Route::post('/registerUser','SettingController@registerUser')->name('registerUser');



