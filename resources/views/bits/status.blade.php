<br/>
<div class="card">
    <div class="card-header">
        <a href="{{route('profile', ['id' => $status->user->id])}}">{{$status->user->name}} {{$status->user->lastname}}</a>
        on
        <a href="{{route('status', ['id' => $status->id])}}">{{$status->created_at->format('d/m/Y')}} at {{$status->created_at->format('H:i')}}</a>
        @if(Auth::user()->id==$status->user->id)
            <a href="#" data-href="{{route('delstatus', $status->id)}}" data-toggle="modal" data-target="#confirm-delete" class="btn btn-secondary btn-sm float-right">Delete</a>
        @endif
    </div>

    <div class="card-body">

        @if($status->type=='image')
            @if($status->subtitle)
                {!! nl2br(e($status->subtitle)) !!}
            @endif
            <a href="{{url('images').'/'.$status->content}}" data-toggle="lightbox"><img src="{{url('images').'/'.$status->content}}" class="col-12"/></a>
        @elseif($status->type=='video')
            @if($status->subtitle)
                {!! nl2br(e($status->subtitle)) !!}
            @endif
            <video class="col-12" controls>
                <source src="{{url('videos').'/'.$status->content}}">
                It doesn't seem like your browser supports HTML5 video in webm, mp4, or ogg format.
            </video>
        @else
            {!! nl2br(e($status->content)) !!}
        @endif
    </div>
    <ul class="list-group list-group-flush" id="comments{{$status->id}}">
        <li class="list-group-item">
            {{ Html::ul($errors->all()) }}

            {{ Form::open(array('url' => '/comments/submit')) }}

            <div class="row">
                {{ Form::textarea('comment', Input::old('comment'), array('class' => 'form-control col-md-10', 'rows' => 1)) }}
                {{ Form::hidden('status', $status->id) }}
                {{ Form::submit('Submit', array('class' => 'btn btn-primary col-md-2')) }}
            </div>



            {{ Form::close() }}
        </li>

        <?php $comments = $status->comments; ?>
    </ul>
</div>
<script>
    $.ajax({
        url: "{{route('getcomments', ['id' => $status->id, 'start' => 0])}}",
        cache: false,
        success: function(html){
            $("#comments{{$status->id}}").append(html);
        }
    });
</script>