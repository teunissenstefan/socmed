@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header">How are you feeling?</div>
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

            @foreach($statuses as $status)
            <br/>
            <div class="card">
                <div class="card-header"><a href="naarprofielgaan">{{$status->user->name}} {{$status->user->lastname}}</a> on <a href="naarpostgaan">{{$status->created_at->format('d/m/Y')}} at {{$status->created_at->format('H:i')}}</a></div>

                <div class="card-body">


                    {!! nl2br(e($status->content)) !!}
                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>
@endsection