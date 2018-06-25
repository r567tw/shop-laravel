<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Validator;
use Hash;
use DB;
use Socialite;
use Mail;
use App\Jobs\SendSignUpMailJob;

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
            'password'=>['required','min:6','same:password_confirmation'],
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
            'nickname' => $input['name'],
            'email' => $input['email']
        ];

        SendSignUpMailJob::dispatch($mail_binding)->onQueue('high');

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

    public function facebookSignInProcess(){
        //return 'facebookSignInProcess';

        $redirect_url = env('FB_REDIRECT');

        return Socialite::driver('facebook')
        ->scopes(['email'])
        ->redirectUrl($redirect_url)
        ->redirect();
    }

    public function facebooksignInCallbackProcess(){

        if(request()->error == 'access_denied'){
            throw new Exception('授權失敗，存取錯誤');
        }

        $redirect_url = env('FB_REDIRECT');

        $FacebookUser = Socialite::driver('facebook')
        ->user();
        //dd($FacebookUser);
        $facebook_email = $FacebookUser->email;

        if(is_null($facebook_email)){
            throw new Exception('未授權取得email');
        }

        //get facebook data
        $facebook_id = $FacebookUser->id;
        $facebook_name = $FacebookUser->name;

        $User = User::where('facebook_id',$facebook_id)->first();

        if(is_null($User)){
            $User = User::where('email',$facebook_email)->first();

            if(!is_null($User))
            {
                $User->facebook_id = $facebook_id;
                $User->save();
            }
            else
            {
                $input =[
                    'email' => $facebook_email,
                    'name' => $facebook_name,
                    'password' => uniqid(),
                    'facebook_id' => $facebook_id,
                    'type' =>'G'
                ];

                $input['password'] = Hash::make($input['password']);
                $User = User::create($input);

                $mail_binding = [
                    'nickname' => $input['name']
                ];

                Mail::send('email.signUpEmailNotification',$mail_binding,function($mail) use ($input){
                    $mail->to($input['email']);
                    $mail->from('shop@laravel.com');
                    $mail->subject('恭喜使用facebook註冊成功！');
                });
            }
        }

        session()->put('user_id',$User->id);
        //重新導向到原本使用者造訪頁面，沒有常識造訪頁則重新導向首頁
        return redirect()->intended('/');
    }
}
