@extends('layouts.app')

@section('pageTitle', 'Edit status')

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
                    <div class="card-header">
                        Edit status
                    </div>
                    <div class="card-body">
                        {{ Html::ul($errors->all()) }}

                        {{ Form::model($status, array('route' => array('statusupdate', $status->id), 'method' => 'PUT')) }}

                        <div class="form-group">
                            {{Form::label('subtitle', 'Subtitle',['class' => ''])}}
                            {{ Form::textarea('subtitle', null, array('class' => 'form-control '.($errors->has('subtitle') ? ' is-invalid' : ''),'required','autofocus','rows' => 2)) }}
                        </div>
                        <div class="form-check-inline">
                            {{Form::label('public', 'Public &nbsp;',['class' => 'form-check-label'])}}
                            {{Form::checkbox('public',null,null, array('class' => 'form-check-input '.($errors->has('public') ? ' is-invalid' : '')))}}
                        </div>
                        <br/>

                        {{ Form::submit('Save status', array('class' => 'btn btn-primary')) }}

                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection