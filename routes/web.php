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
        Route::get('/facebook-sign-in','UserAuthController@facebookSignInProcess');
        Route::get('/facebook-sign-in-callback','UserAuthController@facebookSignInCallbackProcess');
        Route::get('sign-out','UserAuthController@signOut');
    });
});

//merchandise
Route::group(['prefix' => 'merchandise'], function() {
    Route::get('/','MerchandiseController@merchandiseListPage');
    Route::get('/create','MerchandiseController@merchandiseCreateProcess')
    ->middleware(['user.auth.admin']);

    Route::get('/manage','MerchandiseController@merchandiseMangeListPage')
    ->middleware(['user.auth.admin']);


    //merchandise item
    Route::group(['prefix' => '{id}'], function() {
        Route::get('/edit','MerchandiseController@merchandiseItemEditPage')->middleware(['user.auth.admin']);
        Route::put('/','MerchandiseController@merchandiseItemUpdateProcess')->middleware(['user.auth.admin']);
        Route::get('/','MerchandiseController@merchandiseItemPage')->middleware(['user.auth']);
        Route::post('/buy','MerchandiseController@merchandiseItemBuyProcess')->middleware(['user.auth']);
    });
});

//transation
Route::get('/transaction','TransactionController@transactionListPage');
