<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\User;
use Mail;


class SendMerchandiseNewsletterJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $User;
    protected $MerchandiseCollection;

    public function __construct(User $user,$merchandises)
    {
        //
        $this->User = $user;
        $this->MerchandiseCollection = $merchandises;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $mail_binding = [
            'User' =>$this->User,
            'MerchandiseCollection'=>$this->MerchandiseCollection
        ];

        Mail::send('email.merchandiseNewsletter',
                    $mail_binding,
                    function($mail) use ($mail_binding){
                        $mail->to($mail_binding['User']->email);
                        $mail->from('shop@laravel.com');
                        $mail->subject('shop laravel 最新商品電子報');
                    });
        
    }
}
