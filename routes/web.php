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

Route::get('/','HomeController@indexPage');

//USER
Route::group(['prefix'=>'user'],function(){
    //USER VALIDATE
    Route::group(['prefix'=>'auth'],function(){
        Route::get('/sign-up','UserAuthController@signUpPage');
        Route::post('/sign-up','UserAuthController@signUpProcess');
        Route::get('/sign-in','UserAuthController@signInPage');
        Route::post('/sign-in','UserAuthController@signInProcess');
        Route::get('sign-out','UserAuthController@signOut');
    });
});

//merchandise
Route::group(['prefix' => 'merchandise'], function() {
    Route::get('/','MerchandiseController@merchandiseListPage');
    Route::get('/create','MerchandiseController@merchandiseCreateProcess');
    Route::get('/manage','MerchandiseController@merchandiseMangeListPage');

    //merchandise item
    Route::group(['prefix' => '{merchandise_id}'], function() {
        Route::get('/','MerchandiseController@merchandiseItemPage');
        Route::get('/edit','MerchandiseController@merchandiseItemEditPage');
        Route::put('/','MerchandiseController@merchandiseItemUpdateProcess');
        Route::post('/buy','MerchandiseController@merchandiseItemBuyProcess');
    });
});

//transation
Route::get('/transaction','TransactionController@transactionListPage');
