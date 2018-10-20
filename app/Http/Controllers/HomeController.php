<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Status;
use App\User;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$statuses = Status::orderBy('created_at','desc')->get();
        $combinedCollection = Auth::user()->statuses;
        foreach (Auth::user()->friends as $friend){
            $combinedCollection = $combinedCollection->merge($friend->statuses);
        }
        return view('home')->with('statuses',$combinedCollection->sortByDesc('created_at'));
    }
}
