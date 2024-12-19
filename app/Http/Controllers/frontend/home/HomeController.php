<?php

namespace App\Http\Controllers\frontend\home;

use App\Http\Controllers\Controller;
use App\Models\frontend\category\Category;
use App\Models\frontend\currency\Currency;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $categories = Category::where('user_id', auth()->user()->id)->get();
        $currencies = Currency::where('user_id', auth()->user()->id)->get();
        return view('frontend.home.index',compact('categories','currencies'));
    }
}