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
        if (!$validator->fails()) {
            // store
            $comment = new Comment;
            $comment->content       = Input::get('comment');
            $comment->poster       = Auth::user()->id;
            $comment->status       = Input::get('status');
            $comment->save();
            return view('bits.comment')->with('comment',$comment);
        }
    }

    public function getcomments(Request $request, $id, $start){
        $incr = 5;
        $startOffset = 3;
        if($start==0){ $incr = 2; $startOffset = 0;}
        $offset = ($start * $incr) - $startOffset;
        $comments = Comment::where('status',$id)->orderBy('created_at','desc')->limit($incr)->offset($offset)->get();
        $moreAvailable = $this->checkmorecomments($id,$start+1);
        $data = [
            'comments' => $comments,
            'moreAvailable' => $moreAvailable,
            'id' => $id,
            'start' => $start+1
        ];
        return view('bits.getcomments')->with($data);
    }

    protected function checkmorecomments($id,$start){
        $incr = 5;
        $startOffset = 3;
        if($start==0){ $incr = 2; $startOffset = 0;}
        $offset = ($start * $incr) - $startOffset;
        $comments = Comment::where('status',$id)->orderBy('created_at','desc')->limit($incr)->offset($offset)->get();
        if(count($comments)>0){
            return true;
        }
        return false;
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
            //Session::flash('status', 'Successfully deleted the comment!');
            //return Redirect::to('/status/'.$post);
        }else{
            //Session::flash('status', 'Could not delete the comment!');
            //return Redirect::to('/status/'.$post);
        }

    }
}
