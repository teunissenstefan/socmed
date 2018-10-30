@extends('layouts.app')

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
                            <a  href="#" data-href="{{route('friends.unfriend', $user->id)}}" data-toggle="modal" data-target="#confirm-delete" class="btn btn-secondary btn-sm float-right">Unfriend</a>
                        @elseif($friendStatus=="accept")
                            <a href="{{route('friends.accept', $user->id)}}" class="btn btn-primary btn-sm float-right">Accept friend request</a>
                        @elseif($friendStatus=="cancel")
                            <a href="{{route('friends.cancel', $user->id)}}" class="btn btn-secondary btn-sm float-right">Cancel friend request</a>
                        @else
                            <a href="{{route('friends.add', $user->id)}}" class="btn btn-primary btn-sm float-right">Send friend request</a>
                        @endif
                    @endif
                </div>
                <div class="card-body">
                    Gender: {{$user->sex->gender}}<br/>
                    Birthdate: {{$user->birthdate}}
                </div>
            </div>



        </div>
    </div>
</div>
<script>
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