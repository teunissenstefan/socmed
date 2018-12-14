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
                    <div class="card-header">Friends</div>
                    <div class="card-body">

                        <ul class="list-group list-group-flush">
                            @if(count($pendingFriendRequestsForMe)==0&&count($pendingFriendRequests)==0&&count($actualFriends)==0)
                                You've got no friends :(
                            @else
                                @foreach($pendingFriendRequestsForMe as $user)
                                    @include('bits.friend')
                                @endforeach
                                @foreach($pendingFriendRequests as $user)
                                    @include('bits.friend')
                                @endforeach
                                @foreach($actualFriends as $user)
                                    @include('bits.friend')
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection