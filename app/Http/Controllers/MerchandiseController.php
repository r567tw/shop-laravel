<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MerchandiseController extends Controller
{
    // Route::get('/','MerchandiseController@merchandiseListPage');
    public function merchandiseListPage()
    {
        return 'merchandiselistpage';
    }

    // Route::get('/create','MerchandiseController@merchandiseCreateProcess');
    public function merchandiseCreateProcess()
    {
        return 'merchandiseCreateProcess';
    }

    // Route::get('/manage','MerchandiseController@merchandiseMangeListPage');
    public function merchandiseManageListPage()
    {
        return 'merchandiseManageListPage';
    }

    //Route::get('/','MerchandiseController@merchandiseItemPage');mer
    public function merchandiseItemPage()
    {
        return 'merchandiseItemPage';
    }

    //Route::get('/edit','MerchandiseController@merchandiseItemEditPage');
    public function merchandiseItemEditPage()
    {
        return 'merchandiseItemEditPage';
    }

    //Route::put('/','MerchandiseController@merchandiseItemUpdateProcess');
    public function merchandiseUpdateProcess(){
        return 'merchandiseUpdateProcess';
    }

    //Route::post('/buy','MerchandiseController@merchandiseItemBuyProcess');
    public function merchandiseItemBuyProcess(){
        return 'merchandiseItemBuyProcess';
    }
}
