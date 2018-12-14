<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Validator;
use Input;
use Session;
use Redirect;

class MessageController extends Controller
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
        $inbox = Message::where('send_to',Auth::user()->id)->orderBy('created_at', 'desc')->get();
        $outbox = Message::where('send_from',Auth::user()->id)->orderBy('created_at', 'desc')->get();
        $data = [
            'inbox' => $inbox,
            'outbox' => $outbox
        ];
        return view('messages.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($userid)
    {
        $user = User::find($userid);
        if($user===null){
            abort(404);
        }
        $data = [
            'user' => $user
        ];
        return view('messages.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($userid)
    {
        $rules = array(
            'subject'       => 'required',
            'message'       => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);

        // process
        if ($validator->fails()) {
            return Redirect::to('/')
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        } else {
            // store
            $message = new Message;
            $message->send_to       = $userid;
            $message->send_from     = Auth::user()->id;
            $message->message       = Input::get('message');
            $message->subject       = Input::get('subject');
            $message->save();

            // redirect
            Session::flash('status', 'Message sent!');
            return Redirect::to('/messages/');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show($messageid)
    {
        $message = Message::where('id',$messageid)
            ->where(function($q) {
                $q->where('send_from',Auth::user()->id)
                    ->orWhere('send_to',Auth::user()->id);
            })
            ->first();
        if($message===null){
            abort(404);
        }
        if($message->receiver->id==Auth::user()->id){
            $message->read = 1;
            $message->save();
        }
        $data = [
            'message' => $message
        ];
        return view('messages.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        //
    }
}
