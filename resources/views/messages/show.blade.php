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
                        {{$message->sender->name}} {{$message->sender->lastname}} to {{$message->receiver->name}} {{$message->receiver->lastname}}: {{$message->subject}}
                    </div>
                    <div class="card-body">
                        {!! nl2br(e($message->message)) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection