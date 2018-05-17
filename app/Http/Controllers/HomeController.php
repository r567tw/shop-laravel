<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    //indexPage
    public function indexPage(){
        return view('welcome');
    }
}
