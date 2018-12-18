@extends('layouts.app')

@section('pageTitle', 'Feed')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-3">
            <div class="card col-md-12 sticky-top sticky-offset" id="sidebar">
                <div class="card-header">
                    Online friends
                </div>
                <div class="card-body" id="onlineFriends">

                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="col-md-12" id="statuscontainer">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="card" id="postStatusCard" style="display:none;">
                    <div id="tabs">
                        <ul>
                            <li><a href="#tabs-1">Text</a></li>
                            <li><a href="#tabs-2">Image</a></li>
                            <li><a href="#tabs-3">Video</a></li>
                        </ul>
                        <div id="tabs-1">
                            How are you feeling?
                            <div class="card-body">
                                {{ Html::ul($errors->all()) }}

                                {{ Form::open(array('url' => '/submit')) }}

                                <div class="form-group">
                                    {{ Form::textarea('status', Input::old('status'), array('class' => 'form-control', 'rows' => 2)) }}
                                </div>

                                {{ Form::submit('Submit status', array('class' => 'btn btn-primary')) }}

                                {{ Form::close() }}
                            </div>
                        </div>
                        <div id="tabs-2">
                            Submit an image
                            <div class="card-body">
                                {{ Html::ul($errors->all()) }}

                                {{ Form::open(['route' => 'submitimage', 'files' => true]) }}

                                <div class="form-group">
                                    {{Form::label('subtitle', 'Subtitle',['class' => 'control-label'])}}
                                    {{ Form::textarea('subtitle', Input::old('subtitle'), array('class' => 'form-control', 'rows' => 2)) }}
                                </div>
                                <div class="form-group">
                                    {{Form::label('user_photo', 'Image',['class' => 'control-label'])}}
                                    {{Form::file('user_photo')}}
                                </div>

                                {{ Form::submit('Submit image', array('class' => 'btn btn-primary')) }}

                                {{ Form::close() }}
                            </div>
                        </div>
                        <div id="tabs-3">
                            Submit a video
                            <div class="card-body">
                                {{ Html::ul($errors->all()) }}

                                {{ Form::open(['route' => 'submitvideo', 'files' => true]) }}

                                <div class="form-group">
                                    {{Form::label('subtitle', 'Subtitle',['class' => 'control-label'])}}
                                    {{ Form::textarea('subtitle', Input::old('subtitle'), array('class' => 'form-control', 'rows' => 2)) }}
                                </div>
                                <div class="form-group">
                                    {{Form::label('user_video', 'Video',['class' => 'control-label'])}}
                                    {{Form::file('user_video')}}
                                </div>

                                {{ Form::submit('Submit video', array('class' => 'btn btn-primary')) }}

                                {{ Form::close() }}
                            </div>
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
        var url = window.location.href, idx = url.indexOf("#")
        var hash = idx != -1 ? url.substring(idx+1) : "";
        if(hash!=""){
            var index = $('#'+hash).index()-1;
            $("#tabs").tabs("option", "active", index);
            //$('#tabs').tabs('select', "#"+hash);
        }
        $('#postStatusCard').css('display', 'block');
        $.ajax({
            url: "{{route('getstatuseshome', ['start' => 0])}}",
            cache: false,
            success: function(html){
                $("#statuscontainer").append(html);
            }
        });
        onlineFriends();
    } );

    var processing = false;
    var start = 1;
    document.addEventListener('scroll', function (event) {
        if ($(window).scrollTop() >= ($(document).height() - $(window).height())*0.9){
            if(processing==false){
                console.log("ay");
                processing = true;
                var url = '{{ route("getstatuseshome", ":start") }}';
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
    var check30 = setInterval(function () {
        onlineFriends();
    }, 30000);

    function onlineFriends(){
        $.ajax({
            url: "{{route('friends.online')}}",
            cache: false,
            success: function(html){
                $("#onlineFriends").html(html);
            }
        });
    }
</script>
@endsection