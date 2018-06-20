<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Merchandise;
use App\Http\Requests\MerchandiseRequest;
use Validator;

class MerchandiseController extends Controller
{
    // Route::get('/','MerchandiseController@merchandiseListPage');
    public function merchandiseListPage()
    {
        return Merchandise::all();
    }

    // Route::get('/create','MerchandiseController@merchandiseCreateProcess');
    public function merchandiseCreateProcess()
    {
        $merchandise_data = [
            'status' => 'C',
            'name' => '',
            'name_en'=>'',
            'introduction'=>'',
            'introduction_en'=>'',
            'photo' =>0,
            'price' =>0,
            'remain_count' =>0
        ];

        $merchandise = Merchandise::create($merchandise_data);

        return redirect('/merchandise/'.$merchandise->id.'/edit');

    }

    // Route::get('/manage','MerchandiseController@merchandiseMangeListPage');
    public function merchandiseMangeListPage()
    {
        $row_per_page = 1;

        $MerchandisePaginate = Merchandise::OrderBy('created_at','desc')->paginate($row_per_page);

        foreach ($MerchandisePaginate as $merchandise){
            if (!is_null($merchandise->photo)){
                $merchandise->photo = url($merchandise->photo);
            }
        }

        $binding = [
            'title'=> '管理商品',
            'MerchandisePaginate' => $MerchandisePaginate
        ];

        return view('merchandise.manageMerchandise',$binding);
    }

    //Route::get('/','MerchandiseController@merchandiseItemPage');mer
    public function merchandiseItemPage($id)
    {
        return Merchandise::findOrFail($id);
    }

    //Route::get('/edit','MerchandiseController@merchandiseItemEditPage');
    public function merchandiseItemEditPage($id)
    {
        $Merchandise = Merchandise::findorFail($id);

        if (!is_null($Merchandise->photo)){
            $Merchandise->photo = url($Merchandise->photo);
        }

        return view('merchandise.editMerchandise')->withTitle('編輯商品')
                                                ->with(["Merchandise"=>$Merchandise]);
    }

    //Route::put('/','MerchandiseController@merchandiseItemUpdateProcess');
    public function merchandiseItemUpdateProcess(MerchandiseRequest $request,$id){
        
        $Merchandise = Merchandise::findOrFail($id);
        $input = $request->all();
        $Merchandise->update($input);
        $Merchandise->save();

        return redirect('/merchandise/'.$Merchandise->id);
    }

    //Route::post('/buy','MerchandiseController@merchandiseItemBuyProcess');
    public function merchandiseItemBuyProcess(){
        return 'merchandiseItemBuyProcess';
    }
}
