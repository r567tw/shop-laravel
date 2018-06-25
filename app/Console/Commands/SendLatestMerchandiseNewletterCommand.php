<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\SendMerchandiseNewsletterJob;
use App\Merchandise;
use App\User;


class SendLatestMerchandiseNewletterCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shop:sendLatestMerchandiseNewsletter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '[郵件] 寄送最新商品電子報';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $this->info('寄送電子報開始');

        $total_row = 10;
        $MerchandiseCollection = Merchandise::OrderBy('created_at','desc')
        ->where('status','S')
        ->take($total_row)
        ->get();

        $row_per_page =100;
        $page =1;

        while(true){
            $skip = ($page-1)*$row_per_page;

            $UserCollection = User::orderBy('id','asc')
            ->skip($skip)
            ->take($row_per_page)
            ->get();

            if(!$UserCollection->count()){
                break;
            }

            foreach($UserCollection as $user){
                SendMerchandiseNewsletterJob::dispatch($user,$MerchandiseCollection)
                ->onQueue('low');
            }

            $page++;
        }
    }
}
