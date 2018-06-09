<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Hash;
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
