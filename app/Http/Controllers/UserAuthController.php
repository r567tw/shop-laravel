<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserAuthController extends Controller
{
    // Route::get('/sign-up','UserAuthController@signUpPage');
    public function signUpPage(){
        return 'SignUpPage';
    }

    // Route::post('/sign-up','UserAuthController@signUpProcess');
    public function signUpProcess(){
        return 'signUpProdess';
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
