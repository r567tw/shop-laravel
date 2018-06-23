<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;

class TransactionController extends Controller
{
    //Route::get('/transaction','TransactionController@transactionListPage');
    public function transactionListPage()
    {
        $row_per_page = 10;
        $user_id = session()->get('user_id');

        $TransactionPaginate = Transaction::where('user_id',$user_id)
        ->OrderBy('created_at','desc')
        ->with('Merchandise')
        ->paginate($row_per_page);

        foreach ($TransactionPaginate as $transaction){
            if (!is_null($transaction->Merchandise->photo)){
                $transaction->Merchandise->photo = url($transaction->Merchandise->photo);
            }
        }

        $binding = [
            'title'=> '交易紀錄',
            'TransactionPaginate' => $TransactionPaginate
        ];

        return view('transaction.listUserTransaction',$binding);
    }
}
