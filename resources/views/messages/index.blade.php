@extends('layouts.app')

@section('pageTitle', 'Messages')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12" id="statuscontainer">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">{{ session('status') }}</div>
                @endif

                <div class="card">
                    <div class="card-header">
                        Messages
                    </div>
                    <div class="card-body card-body-profile">
                        <div id="tabs">
                            <ul>
                                <li><a href="#tabs-1">Inbox</a></li>
                                <li><a href="#tabs-2">Outbox</a></li>
                            </ul>
                            <div id="tabs-1">
                                <ul class="list-group">
                                    @if(count($inbox)>0)
                                        @foreach($inbox as $message)
                                            <a href="{{route('messages.show', $message->id)}}" class="@if($message->read==0) unread-msg @endif"><li class="list-group-item">{{$message->subject}}</li></a>
                                        @endforeach
                                    @else
                                        No messages
                                    @endif
                                </ul>
                            </div>
                            <div id="tabs-2">
                                <ul class="list-group">
                                    @if(count($outbox)>0)
                                        @foreach($outbox as $message)
                                            <a href="{{route('messages.show', $message->id)}}"><li class="list-group-item">{{$message->subject}}</li></a>
                                        @endforeach
                                    @else
                                        No messages
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $( function() {
            $( "#tabs" ).tabs();
        } );
    </script>
@endsection