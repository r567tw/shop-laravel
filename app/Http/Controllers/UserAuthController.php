<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Hash;
use Mail;
use App\User;
use DB;

class UserAuthController extends Controller
{
    // Route::get('/sign-up','UserAuthController@signUpPage');
    public function signUpPage(){
        $binding =[
            'title' => '註冊'
        ];

        return view('auth.signUp',$binding);
    }

    // Route::post('/sign-up','UserAuthController@signUpProcess');
    public function signUpProcess(){
        //GET input data
        $input = request()->all();
        $rules = [
            'name'=>['required','max:50'],
            'email'=>['required','max:150','email'],
            'password'=>['required','max:6','same:password_confirmation'],
            'password_confirmation'=>['required','min:6'],
            'type' => ['required','in:G,A']
        ];

        $validator = Validator::make($input,$rules);

        if ($validator->fails())
        {
            return redirect('/user/auth/sign-up')->withErrors($validator)
                                                ->withInput();
        }

        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        //send email to do
        $mail_binding =[
            'nickname' => $input['name']
        ];

        Mail::send('email.signUpEmailNotification',$mail_binding,function($mail) use ($input){
            $mail->to($input['email']);
            $mail->from('admin@shop-laravel.com');
            $mail->subject('恭喜註冊shop-laravel 成功');
        });

        return redirect('/user/auth/sign-in');
    }
    
    // Route::get('/sign-in','UserAuthController@signInPage');
    public function signInPage(){
        
        return view('auth.signIn')->withTitle('登入');
    }

    // Route::post('/sign-in','UserAuthController@signInProcess');
    public function signInProcess(){
        
        $input = request()->all();
        $rules =[
            'email'=>['required','max:150','email'],
            'password'=>['required','min:6']
        ];

        $validator = Validator::make($input,$rules);

        if ($validator->fails())
        {
            return redirect('/user/auth/sign-in')->withErrors($validator)
                ->withInput();
        }
        //DB::enableQueryLog();
        $User = User::where('email',$input['email'])->firstOrFail();
        //dd(DB::getQueryLog());
        $is_password_correct = Hash::check($input['password'],$User->password);

        if(!$is_password_correct)
        {
            $error_msg = ['msg'=>['密碼驗證錯誤']];
            return redirect('/user/auth/sign-in')->withErrors($error_msg)->withInput();
        }
        else
        {
            session()->put('user_id',$User->id);
            return 'Log in!!';
        }

    }

    // Route::get('sign-out','UserAuthController@signOut');
    public function signOut()
    {
        session()->forget('user_id');
        return redirect('/');
    }
}
