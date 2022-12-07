<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Items;
use App\User;
use Auth;
use DB;


class FaqController extends Controller
{
    public function faq(){
        $modules = explode(',', Auth::user()->access_modules);
        return view('faq.index',compact('modules'));
    }
}