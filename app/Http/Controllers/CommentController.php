<?php

namespace App\Http\Controllers;

use App\Comment;
use Validator;
use Auth;
use Session;
use Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class CommentController extends Controller
{
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = array(
            'comment'       => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);

        // process
        if ($validator->fails()) {
            return Redirect::to('/status/'.Input::get('status'))
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        } else {
            // store
            $comment = new Comment;
            $comment->content       = Input::get('comment');
            $comment->poster       = Auth::user()->id;
            $comment->status       = Input::get('status');
            $comment->save();

            // redirect
            Session::flash('status', 'Comment posted!');
            return Redirect::to('/status/'.Input::get('status'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $comment = Comment::find($id);
        $post = $comment->status;
        if(Auth::user()->id==$comment->user->id){
            $comment->delete();

            // redirect
            Session::flash('status', 'Successfully deleted the comment!');
            return Redirect::to('/status/'.$post);
        }else{
            Session::flash('status', 'Could not delete the comment!');
            return Redirect::to('/status/'.$post);
        }

    }
}
