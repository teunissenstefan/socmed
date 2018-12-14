<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Status;
use App\User;
use Auth;
use Illuminate\Support\Facades\Redirect;
use Input;
use Carbon\Carbon;

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
        $onlinefriends = User::where('last_online','>=',Carbon::now()->subMinutes(5)->toDateTimeString())
            ->where(function($q) {
                    $q->whereIn('id', function($query){
                        $query->select('friend_id')
                            ->from('friends')
                            ->where('accepted',1)
                            ->where('user_id','=',Auth::user()->id);
                    })->orWhereIn('id', function($query){
                        $query->select('user_id')
                            ->from('friends')
                            ->where('accepted',1)
                            ->where('friend_id','=',Auth::user()->id);
                    });
                })->get();
        return view('home')->with('onlinefriends',$onlinefriends);
    }

    public function search(Request $request, $searchQuery){
        //$users =  User::where('email', $searchQuery)->orWhere('name', 'like', '%' . $searchQuery . '%')->get(); //de oude
        $users =  User::whereRaw('concat(name," ",lastname) like ?', "%{$searchQuery}%")->orWhere('email', $searchQuery)->get();
        $data = [
            'users' => $users,
            'searchQuery' => $searchQuery
        ];
        return view('search')->with($data);
    }

    public function processSearchForm(Request $request){
        $searchQuery = Input::get('searchQuery');
        return Redirect::to('search/'.$searchQuery) ;
    }
}
