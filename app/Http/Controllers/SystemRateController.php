<?php

namespace App\Http\Controllers;
use App\SystemRate;
use Illuminate\Http\Request;

class SystemRateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if(\Auth::user()->role!=0)
            return redirect()->route('home')->with('error',"You Cann't Open This Page");
        // sortByDesc
        $rates=SystemRate::all()->sortByDesc('created_at');
        // $links = $checks ->appends(['sort' => 'created_at'])->links();
        $now=\Carbon\Carbon::now();
        return view('admin.system_rates',compact(['rates','now']));
    }
}
