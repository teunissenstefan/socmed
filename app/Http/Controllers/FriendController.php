<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use Session;
use Redirect;
use App\Friend;
use Illuminate\Http\Request;

class FriendController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $pendingFriendRequests = $user->pendingFriendRequests;
        $pendingFriendRequestsForMe = $user->pendingFriendRequestsForMe;
        $actualFriends = $user->friends;
        $data = [
            'user' => $user,
            'pendingFriendRequests' => $pendingFriendRequests,
            'pendingFriendRequestsForMe' => $pendingFriendRequestsForMe,
            'actualFriends' => $actualFriends
        ];
        return view('friends')->with($data);
    }

    public function addfriend(Request $request, $id){
        $checkfriendship = Friend::where('user_id',Auth::user()->id)->where('friend_id',$id)->first();
        $checkfriendship2 = Friend::where('friend_id',Auth::user()->id)->where('user_id',$id)->first();
        if($checkfriendship === null && $checkfriendship2 === null){
            $friendship = new Friend;
            $friendship->user_id       = Auth::user()->id;
            $friendship->friend_id       = $id;
            $friendship->save();
            Session::flash('status', 'Friend request sent!');
            return Redirect::back();
        }
        abort(404);
    }

    public function cancelrequest(Request $request, $id){
        $friendship = Friend::where('user_id',Auth::user()->id)->where('friend_id',$id)->where('accepted',0)->first();
        if ($friendship === null) {
            abort(404);
        }
        $friendship->delete();
        Session::flash('status', 'Friend request canceled!');
        return Redirect::back();
    }

    public function acceptrequest(Request $request, $id){
        $friendship = Friend::where('friend_id',Auth::user()->id)->where('user_id',$id)->where('accepted',0)->first();
        if($friendship === null){
            abort(404);
        }
        $friendship->accepted = 1;
        $friendship->save();
        Session::flash('status', 'Friend request accepted!');
        return Redirect::back();
    }

    public function unfriend(Request $request, $id){
        $friendship = Friend::where('friend_id',Auth::user()->id)->where('user_id',$id)->where('accepted',1)->first();
        if($friendship !== null){
            $friendship->delete();
            Session::flash('status', 'User has been unfriended!');
            return Redirect::back();
        }else{
            $friendship = Friend::where('user_id',Auth::user()->id)->where('friend_id',$id)->where('accepted',1)->first();
            if($friendship !== null){
                $friendship->delete();
                Session::flash('status', 'User has been unfriended!');
                return Redirect::back();
            }
        }
        abort(404);
    }
}
