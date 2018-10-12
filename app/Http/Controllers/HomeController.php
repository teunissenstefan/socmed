<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Status;
use App\User;

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
        $statuses = Status::orderBy('created_at','desc')->get();
        return view('home')->with('statuses',$statuses);
    }

    public function profile(Request $request, $id)
    {
        $user = User::find($id);
        //$statuses = Status::where('poster',$id)->orderBy('created_at','desc')->get();
        if ($user === null) {
            abort(404);
        }
        $data = [
            'user' => $user,
            //'statuses' => $statuses
        ];
        return view('profile')->with($data);
    }
}
