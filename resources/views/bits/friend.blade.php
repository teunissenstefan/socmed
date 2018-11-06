<li class="list-group-item">
    <a href="{{route('profile', ['id' => $user->id])}}">{{$user->name}} {{$user->lastname}}</a>
    @if($user->pivot->accepted == 0)
        @if($user->pivot->user_id==Auth::user()->id)
            <a href="{{route('friends.cancel', $user->id)}}" class="btn btn-secondary btn-sm float-right">Cancel friend request</a>
        @else
            <a href="{{route('friends.accept', $user->id)}}" class="btn btn-primary btn-sm float-right">Accept friend request</a>
        @endif
    @else
        <a  href="#" data-href="{{route('friends.unfriend', $user->id)}}" data-toggle="modal" data-target="#confirm-delete" class="btn btn-secondary btn-sm float-right">Unfriend</a>
    @endif
</li>