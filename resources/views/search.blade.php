@extends('layouts.app')

@section('pageTitle', 'Search')

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
                    <div class="card-header">People</div>
                    <div class="card-body">

                        <ul class="list-group list-group-flush">
                            @if(count($users)>0)
                                @foreach($users as $user)
                                    @include('bits.user')
                                @endforeach
                            @else
                                No people found
                            @endif
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection