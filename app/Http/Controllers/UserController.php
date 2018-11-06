<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Status;
use App\User;
use GuzzleHttp;
use App\Gender;
use Validator;
use Input;
use Redirect;
use Session;
use Auth;
class UserController extends Controller
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

    }

    public function update($id)
    {
        if(Auth::user()->id==$id) {
            $rules = array(
                'name' => 'required|string|max:255',
                'lastname' => 'required|string|max:255',
                'github_username' => 'max:255',
                'birthdate' => 'required|date|date_format:Y-m-d',
                'gender' => 'required|integer',
                'email' => 'required|string|email|max:255|unique:users,email,' . $id . ',id'
            );
            $validator = Validator::make(Input::all(), $rules);

            if ($validator->fails()) {
                return Redirect::to('profile/' . $id . '/edit')
                    ->withErrors($validator)
                    ->withInput(Input::except('password'));
            } else {
                // store
                $user = User::find($id);
                $user->name = Input::get('name');
                $user->lastname = Input::get('lastname');
                $user->birthdate = Input::get('birthdate');
                $user->gender = Input::get('gender');
                $user->github_username = Input::get('github_username');
                $user->email = Input::get('email');
                $user->save();

                // redirect
                Session::flash('status', 'Successfully updated profile!');
                return Redirect::to('profile/' . $id);
            }
        }else{
            return Redirect::to('profile/' . $id);
        }
    }

    public function edit(Request $request, $id){
        if(Auth::user()->id==$id) {
            $user = User::find($id);
            $genders = Gender::orderBy('id', 'asc')->get();

            $data = [
                'user' => $user,
                'genders' => $genders
            ];
            return view('users.edit')->with($data);
        }else{
            return Redirect::to('profile/' . $id);
        }
    }

    public function show(Request $request, $id)
    {
        $user = User::find($id);
        try{
            $client = new GuzzleHttp\Client();
            $res = $client->get('https://api.github.com/users/'.$user->github_username.'/repos');
            $repositories = json_decode($res->getBody(),true);
        } catch (GuzzleHttp\Exception\ClientException $exception) {
            $repositories = "";
        }

        if($user->friends->contains('id',Auth::user()->id)){
            $friendStatus = "unfriend";
        }else if($user->pendingFriendRequests->contains('id',Auth::user()->id)){
            $friendStatus = "accept";
        }else if($user->pendingFriendRequestsForMe->contains('id',Auth::user()->id)){
            $friendStatus = "cancel";
        }else{
            $friendStatus = "befriend";
        }
        if ($user === null) {
            abort(404);
        }
        $data = [
            'user' => $user,
            'friendStatus' => $friendStatus,
            'repositories' => $repositories
        ];
        return view('users.profile')->with($data);
    }
}
