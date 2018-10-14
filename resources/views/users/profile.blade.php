@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">{{ session('status') }}</div>
                @endif

                <div class="card">
                    <div class="card-header">
                        {{$user->name}} {{$user->lastname}}
                        @if(Auth::user()->id==$user->id)
                            <a href="{{route('profileedit', $user->id)}}" class="float-right">Edit</a>
                        @endif
                    </div>
                    <div class="card-body">
                        Gender: {{$user->sex->gender}}<br/>
                        Birthdate: {{$user->birthdate}}
                    </div>
                </div>

                @foreach($user->statuses as $status)
                        @include('bits.status')
                @endforeach

            </div>
        </div>
    </div>
@endsection