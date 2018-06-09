<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Hash;
use Mail;
use App\User;

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
        return 'SignInPage';
    }

    // Route::post('/sign-in','UserAuthController@signInProcess');
    public function signInProcess(){
        return 'sIGNiNprocess';
    }

    // Route::get('sign-out','UserAuthController@signOut');
    public function signOut()
    {
        return 'SIGNOUT';
    }
}
