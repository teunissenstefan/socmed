<li class="list-group-item">
    <a href="{{route('profile', ['id' => $user->id])}}">{{$user->name}} {{$user->lastname}}</a>
    @if($user->pivot->accepted == 0)
        @if($user->pivot->user_id==Auth::user()->id)
            <a href="#" data-href="" data-toggle="modal" data-target="#confirm-delete" class="float-right">Cancel request</a>
        @else
            <a href="#" data-href="" data-toggle="modal" data-target="#confirm-delete" class="float-right">Accept request</a>
        @endif
    @else
        <a href="#" data-href="" data-toggle="modal" data-target="#confirm-delete" class="float-right">Delete friend</a>
    @endif
</li>