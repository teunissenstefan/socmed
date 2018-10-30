<?php

namespace App\Http\Controllers;

use App\Status;
use App\Comment;
use Auth;
use Session;
use Redirect;
use App\User;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class StatusController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function getstatuseshome($start){
        $incr = 5;
        $offset = ($start * $incr);

        $friends = Auth::user()->friends;
        if(count($friends)==0){
            $statuses = Status::orderBy('created_at','desc')->limit($incr)->offset($offset)->get();
            return view('bits.getstatuses')->with('statuses',$statuses);
        }
        $combinedCollection = Status::select('*')
            ->whereIn('poster', function($query){
                $query->select('friend_id')
                    ->from('friends')
                    ->where('user_id','=',Auth::user()->id)
                    ->orWhere('friend_id','=',Auth::user()->id);
            })
            ->orWhereIn('poster', function($query){
                $query->select('user_id')
                    ->from('friends')
                    ->where('user_id','=',Auth::user()->id)
                    ->orWhere('friend_id','=',Auth::user()->id);
            })->orderBy('created_at','desc')->limit($incr)->offset($offset)->get();
        return view('bits.getstatuses')->with('statuses',$combinedCollection);
    }

    public function getstatusesprofile($id,$start){
        return view('bits.getstatuses')->with('statuses',User::find($id)->statuses);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = array(
            'status'       => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);

        // process
        if ($validator->fails()) {
            return Redirect::to('/')
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        } else {
            // store
            $status = new Status;
            $status->content       = Input::get('status');
            $status->poster       = Auth::user()->id;
            $status->save();

            // redirect
            Session::flash('status', 'Status posted!');
            return Redirect::to('/');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $status = Status::find($id);

        if ($status === null) {
            abort(404);
        }
        $data = [
            'status' => $status
        ];
        return view('status')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function edit(Status $status)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Status $status)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $status = Status::find($id);
        $user = $status->poster;
        if(Auth::user()->id==$user){
            $status->delete();

            // redirect
            Session::flash('status', 'Successfully deleted the status!');
            return Redirect::to('/profile/'.$user);
        }else{
            Session::flash('status', 'Could not delete the status!');
            return Redirect::to('/status/'.$id);
        }

    }
}
