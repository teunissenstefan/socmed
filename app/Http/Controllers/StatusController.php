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
            $statuses = Status::orderBy('created_at','desc')->where('public', 1)->orWhere('poster', Auth::user()->id)->limit($incr)->offset($offset)->get();
            return view('bits.getstatuses')->with('statuses',$statuses);
        }
        $combinedCollection = Status::select('*')
            ->whereIn('poster', function($query){
                $query->select('friend_id')
                    ->from('friends')
                    ->where('accepted',1)
                    ->where(function($q) {
                        $q->where('user_id','=',Auth::user()->id)
                            ->orWhere('friend_id','=',Auth::user()->id);
                    });
            })
            ->orWhereIn('poster', function($query){
                $query->select('user_id')
                    ->from('friends')
                    ->where('accepted',1)
                    ->where(function($q) {
                        $q->where('user_id','=',Auth::user()->id)
                            ->orWhere('friend_id','=',Auth::user()->id);
                    });
            })->orderBy('created_at','desc')->limit($incr)->offset($offset)->get();
        return view('bits.getstatuses')->with('statuses',$combinedCollection);
    }

    public function getstatusesprofile($id,$start){
        $incr = 5;
        $offset = ($start * $incr);
        if($id==Auth::user()->id) {
            $statuses = Status::where('poster','=',$id)->orderBy('created_at','desc')->limit($incr)->offset($offset)->get();
        }else{
            $statuses = Status::where('poster','=',$id)
                ->where(function($q) {
                    $q->where('public', 1)
                        ->orWhere(function($q) {
                            $q->whereIn('poster', function($query){
                                $query->select('friend_id')
                                    ->from('friends')
                                    ->where('accepted',1)
                                    ->where(function($q) {
                                        $q->where('user_id','=',Auth::user()->id)
                                            ->orWhere('friend_id','=',Auth::user()->id);
                                    });
                            })->orWhereIn('poster', function($query){
                                    $query->select('user_id')
                                        ->from('friends')
                                        ->where('accepted',1)
                                        ->where(function($q) {
                                            $q->where('user_id','=',Auth::user()->id)
                                                ->orWhere('friend_id','=',Auth::user()->id);
                                        });
                                });
                        });
                })
                ->orderBy('created_at','desc')->limit($incr)->offset($offset)->get();
        }
//        return $statuses;
        return view('bits.getstatuses')->with('statuses',$statuses);
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
            $status->subtitle       = Input::get('status');
            $status->poster       = Auth::user()->id;
            $status->save();

            // redirect
            Session::flash('status', 'Status posted!');
            return Redirect::to('/status/'.$status->id);
        }
    }

    public function storeimage(Request $request)
    {
        $rules = array(
            'user_photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:50000'
        );
        $validator = Validator::make(Input::all(), $rules);

        // process
        if ($validator->fails()) {
            return Redirect::to('/#tabs-2')
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        } else {
            $photoName = Auth::user()->id.time().'.'.$request->user_photo->getClientOriginalExtension();
            $request->user_photo->move(public_path('images'), $photoName);
            // store
            $status = new Status;
            $status->content       = $photoName;
            $status->poster       = Auth::user()->id;
            $status->type       = 'image';
            $status->subtitle       = $request->subtitle;
            $status->save();

            // redirect
            Session::flash('status', 'Image posted!');
            return Redirect::to('/status/'.$status->id);
        }
    }

    public function storevideo(Request $request)
    {
        $rules = array(
            'user_video' => 'required|mimetypes:video/webm,video/ogg,video/mp4|max:50000'
        );
        $validator = Validator::make(Input::all(), $rules);

        // process
        if ($validator->fails()) {
            return Redirect::to('/#tabs-3')
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        } else {
            $videoName = Auth::user()->id.time().'.'.$request->user_video->getClientOriginalExtension();
            $request->user_video->move(public_path('videos'), $videoName);
            // store
            $status = new Status;
            $status->content       = $videoName;
            $status->poster       = Auth::user()->id;
            $status->type       = 'video';
            $status->subtitle       = $request->subtitle;
            $status->save();

            // redirect
            Session::flash('status', 'Video posted!');
            return Redirect::to('/status/'.$status->id);
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
        $status = Status::where('id',$id)->
            where(function($q) {
                $q->where('public', 1)
                ->orWhere('poster',Auth::user()->id)
                ->orWhere(function($q) {
                    $q->whereIn('poster', function($query){
                        $query->select('friend_id')
                            ->from('friends')
                            ->where('accepted',1)
                            ->where(function($q) {
                                $q->where('user_id','=',Auth::user()->id)
                                    ->orWhere('friend_id','=',Auth::user()->id);
                            });
                    })->orWhereIn('poster', function($query){
                        $query->select('user_id')
                            ->from('friends')
                            ->where('accepted',1)
                            ->where(function($q) {
                                $q->where('user_id','=',Auth::user()->id)
                                    ->orWhere('friend_id','=',Auth::user()->id);
                            });
                    });
                });
            })->first();

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
    public function edit($id)
    {
        $status = Status::find($id);

        if ($status === null) {
            abort(404);
        }
        if(Auth::user()->id!=$status->poster) {
            return Redirect::to('status/' . $id);
        }
        $data = [
            'status' => $status
        ];
        return view('editstatus')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $status = Status::find($id);

        if ($status === null) {
            abort(404);
        }
        if(Auth::user()->id!=$status->poster) {
            return Redirect::to('status/' . $id);
        }
        $status = Status::find($id);
        $public = 0;
        if(Input::get('public')){
            $public = 1;
        }
        $status->subtitle = Input::get('subtitle');
        $status->public = $public;
        $status->save();

        // redirect
        Session::flash('status', 'Successfully updated status!');
        return Redirect::to('status/' . $id);
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
