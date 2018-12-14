@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12" id="statuscontainer">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">{{ session('status') }}</div>
                @endif

                <div class="card">
                    <div class="card-header">
                        Reply to "{{$message->subject}}" from {{$message->sender->name}} {{$message->sender->lastname}}
                    </div>
                    <div class="card-body">
                        {{ Html::ul($errors->all()) }}

                        {{ Form::open(array('url' => '/messages/new/'.$message->sender->id)) }}

                        <div class="form-group">
                            {{Form::label('subject', 'Subject',['class' => 'control-label'])}}
                            {{ Form::text('subject', "Re:".$message->subject, array('class' => 'form-control')) }}
                        </div>
                        <div class="form-group">
                            {{Form::label('message', 'Message',['class' => 'control-label'])}}
                            {{ Form::textarea('message', Input::old('message'), array('class' => 'form-control', 'rows' => 2)) }}
                        </div>

                        {{ Form::submit('Send message', array('class' => 'btn btn-primary')) }}

                        {{ Form::close() }}
                        <hr/>
                        <div>
                            {!! nl2br(e($message->message)) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection