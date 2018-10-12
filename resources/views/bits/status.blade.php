<br/>
<div class="card">
    <div class="card-header"><a href="{{route('profile', ['id' => $status->user->id])}}">{{$status->user->name}} {{$status->user->lastname}}</a> on <a href="{{route('status', ['id' => $status->id])}}">{{$status->created_at->format('d/m/Y')}} at {{$status->created_at->format('H:i')}}</a></div>

    <div class="card-body">


        {!! nl2br(e($status->content)) !!}
    </div>
    <ul class="list-group list-group-flush">
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

        @foreach($status->comments as $comment)
            @include('bits.comment')
        @endforeach
    </ul>
</div>