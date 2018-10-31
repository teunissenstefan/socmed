@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8" id="statuscontainer">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <div class="card">
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
                        Select an image
                        <div class="card-body">
                            {{ Html::ul($errors->all()) }}

                            {{ Form::open(['route' => 'submitimage', 'files' => true]) }}

                            <div class="form-group">
                                {{Form::label('user_photo', 'Image',['class' => 'control-label'])}}
                                {{Form::file('user_photo')}}
                            </div>

                            {{ Form::submit('Submit image', array('class' => 'btn btn-primary')) }}

                            {{ Form::close() }}
                        </div>
                    </div>
                    <div id="tabs-3">
                        Video uploaden
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
        url: "{{route('getstatuseshome', ['start' => 0])}}",
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
</script>
@endsection