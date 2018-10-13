<li class="list-group-item comment">
    <p>
        <a href="{{route('profile', ['id' => $comment->user->id])}}">{{$comment->user->name}} {{$comment->user->lastname}}</a>
        @if(Auth::user()->id==$comment->user->id)
            <a href="#" data-href="{{route('delcomment', $comment->id)}}" data-toggle="modal" data-target="#confirm-delete" class="float-right">Delete</a>
        @endif
    </p>
    {!! nl2br(e($comment->content)) !!}
</li>