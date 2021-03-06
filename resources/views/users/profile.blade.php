@extends('layouts.app')

@section('pageTitle', $user->name." ".$user->lastname)

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8" id="statuscontainer">
            @if (session('status'))
                <div class="alert alert-success" role="alert">{{ session('status') }}</div>
            @endif

            <div class="card">
                <div class="card-header">
                    {{$user->name}} {{$user->lastname}}
                    @if(Auth::user()->id==$user->id)
                        <a href="{{route('profileedit', $user->id)}}" class="btn btn-primary btn-sm float-right">Edit</a>
                    @else
                        @if($friendStatus=="unfriend")
                            <a  href="#" data-href="{{route('friends.unfriend', $user->id)}}" data-toggle="modal" data-target="#confirm-unfriend" class="btn btn-secondary btn-sm float-right">Unfriend</a>
                        @elseif($friendStatus=="accept")
                            <a href="{{route('friends.accept', $user->id)}}" class="btn btn-primary btn-sm float-right">Accept friend request</a>
                        @elseif($friendStatus=="cancel")
                            <a href="{{route('friends.cancel', $user->id)}}" class="btn btn-secondary btn-sm float-right">Cancel friend request</a>
                        @else
                            <a href="{{route('friends.add', $user->id)}}" class="btn btn-primary btn-sm float-right">Send friend request</a>
                        @endif
                    @endif
                    <a href="{{route('messages.new', $user->id)}}" class="btn btn-primary btn-sm float-right mr-1">Message</a>
                </div>
                <div class="card-body card-body-profile">
                    <div id="tabs">
                        <ul>
                            <li><a href="#tabs-1">Info</a></li>
                            <li><a href="#tabs-2">Friends</a></li>
                            @if($repositories)
                                <li><a href="#tabs-3">Repositories</a></li>
                            @endif
                        </ul>
                        <div id="tabs-1">
                            Gender: {{$user->sex->gender}}<br/>
                            Age: {{$user::age($user->birthdate)}}
                        </div>
                        <div id="tabs-2">
                            @if(count($user->friends)>0)
                                <ul class="list-group">
                                    @foreach($user->friends as $friend)
                                        <a href="{{route('profile', ['id' => $friend->id])}}"><li class="list-group-item">{{$friend->name}} {{$friend->lastname}}</li></a>
                                    @endforeach
                                </ul>
                            @else
                                This user has no friends yet :(
                            @endif
                        </div>
                        @if($repositories)
                            <div id="tabs-3">
                                <ul class="list-group">
                                    @foreach($repositories as $repo)
                                        <a href="{{$repo['html_url']}}" target="_blank"><li class="list-group-item">{{$repo['name']}}</li></a>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
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

    $.ajax({
        url: "{{route('getstatusesprofile', ['id' => $user->id,'start' => 0])}}",
        cache: false,
        success: function(html){
            $("#statuscontainer").append(html);
        }
    });

    var processing = false;
    var start = 1;
    document.addEventListener('scroll', function (event) {
        if ($(window).scrollTop() >= ($(document).height() - $(window).height())*0.9){
            if(processing==false){
                console.log("ay");
                processing = true;
                var url = '{{route('getstatusesprofile', ['id' => $user->id,'start' => ':start'])}}';
                url = url.replace(':start', start);
                $.ajax({
                    url: url,
                    cache: false,
                    success: function(html){
                        processing = false;
                        $("#statuscontainer").append(html);
                        start++;
                    }
                });
            }
        }
    }, true);
</script>
@endsection