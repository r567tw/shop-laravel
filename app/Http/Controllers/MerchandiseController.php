<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Merchandise;
use App\Transaction;
use App\User;
use App\Http\Requests\MerchandiseRequest;
use App\Http\Requests\BuyMerchandiseRequest;
use Validator;
use DB;
use Log;

class MerchandiseController extends Controller
{
    // Route::get('/','MerchandiseController@merchandiseListPage');
    public function merchandiseListPage()
    {
        $row_per_page = 10;

        $MerchandisePaginate = Merchandise::OrderBy('created_at','desc')->where('status','S')->paginate($row_per_page);

        foreach ($MerchandisePaginate as $merchandise){
            if (!is_null($merchandise->photo)){
                $merchandise->photo = url($merchandise->photo);
            }
        }

        $binding = [
            'title'=> '商品列表',
            'MerchandisePaginate' => $MerchandisePaginate
        ];

        return view('merchandise.listMerchandise',$binding);    
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
        $row_per_page = 10;

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
        $merchandise = Merchandise::findOrFail($id);

        if (!is_null($merchandise->photo)){
            $merchandise->photo = url($merchandise->photo);
        }

        $binding = [
            'title'=> '商品',
            'Merchandise' => $merchandise
        ];

        return view('merchandise.showMerchandise',$binding);
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
    public function merchandiseItemBuyProcess($id,BuyMerchandiseRequest $request){
        $input = $request->all();
        //DB::connection()->enableQueryLog();
        try{
            $user_id = session()->get('user_id');
            $User = User::findOrFail($user_id);
            DB::beginTransaction();
            $merchandise =Merchandise::findOrFail($id);
            $buy_count = $input['buy_count'];
            $remain_count_after_buy = $merchandise->remain_count - $buy_count;
            if ($remain_count_after_buy <0){
                //購買數量剩餘數量小於0 不足以賣給使用者
                throw new Exception('商品數量不足，無法購買');
            }

            $merchandise->remain_count = $remain_count_after_buy;
            $merchandise->save();

            $total_price = $buy_count*$merchandise->price;

            $transaction_data =[ 
                'user_id' => $User->id,
                'merchandise_id' => $merchandise->id,
                'price' => $merchandise->price,
                'buy_count' => $buy_count,
                'total_price'=>$total_price
            ];

            Transaction::create($transaction_data);
            DB::commit();
            $message = ['msg'=>['購買成功']];
            $queries = DB::getQueryLog();
            //Log::info('Transaction'.print_r($queries));

            return redirect()->to('/merchandise/'.$merchandise->id)->withErrors($message);


        }catch(Exception $exception)
        {

            DB::rollBack();
            $error_message =[
                'msg' =>[$exception->getMessage()]
            ];
            return redirect()->back()->withErrors($message)->withInput();
        }

    }
}
