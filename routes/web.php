<?php

use Illuminate\Support\Facades\Route;

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
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware('auth')->group(function(){
    Route::get('/transaction', 'TransactionController@index')->name('transaction.index');
    Route::post('/transaction/store', 'TransactionController@store')->name('transaction.store');

    Route::get('/discount-tier','DiscountTierController@index')->name('discount-tier.index');
    Route::post('/discount-tier/store','DiscountTierController@store')->name('discount-tier.store');
    Route::get('/discount-tier/{tier}/edit','DiscountTierController@edit')->name('discount-tier.edit');
    Route::put('/discount-tier/{tier}/update','DiscountTierController@update')->name('discount-tier.update');
    Route::delete('/discount-tier/{tier}/destroy','DiscountTierController@destroy')->name('dicount-tier.destroy');
});
