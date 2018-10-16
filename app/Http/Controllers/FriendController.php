<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
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
}
