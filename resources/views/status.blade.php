@extends('layouts.app')

@section('pageTitle', 'Status')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                @include('bits.status')

            </div>
        </div>
    </div>
@endsection