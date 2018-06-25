<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mail;

class SendSignUpMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $mail_binding;

    public function __construct($mail_binding)
    {
        //
        $this->mail_binding = $mail_binding;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $mail_binding = $this->mail_binding;

        Mail::send('email.signUpEmailNotification',
                    $mail_binding,
                    function($mail) use ($mail_binding){
                        $mail->to($mail_binding['email']);
                        $mail->from('shop@laravel.com');
                        $mail->subject('恭喜註冊shop laravel 成功');
                    });
        
    }
}
