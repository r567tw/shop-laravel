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

Route::get('/','HomeController@index');
Route::get('/home','HomeController@index');

//USER
Auth::routes();
Route::group(['prefix'=>'user'],function(){
    Route::group(['prefix'=>'auth'],function(){
        Route::get('/facebook-sign-in','UserAuthController@facebookSignInProcess');
        Route::get('/facebook-sign-in-callback','UserAuthController@facebookSignInCallbackProcess');
    });
});

//merchandise
Route::group(['prefix' => 'merchandise'], function() {
    Route::get('/','MerchandiseController@merchandiseListPage');
    //merchandise item
    Route::group(['prefix' => '{id}'], function() {
        Route::post('/buy','MerchandiseController@merchandiseItemBuyProcess')->middleware(['auth']);
    });
});

//transation
Route::get('/transaction','TransactionController@transactionListPage');

Route::group(['prefix'=>'admin'],function(){

    Route::group(['prefix'=>'merchandises'],function(){
        Route::get('/create','MerchandiseController@create');
        Route::post('/','MerchandiseController@merchandiseCreateProcess');
        Route::get('/manage','MerchandiseController@merchandiseMangeListPage')
        ->middleware(['user.auth.admin']);

        Route::group(['prefix' => '{id}'], function() {
            Route::get('/','MerchandiseController@merchandiseItemPage');
            Route::get('/edit','MerchandiseController@merchandiseItemEditPage');
            Route::put('/','MerchandiseController@merchandiseItemUpdateProcess');
        });

    });



    //merchandise item
});

