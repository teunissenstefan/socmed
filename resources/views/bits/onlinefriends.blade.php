@if(count($onlinefriends)>0)
    @foreach($onlinefriends as $user)
        <a href="{{route('profile', ['id' => $user->id])}}">{{$user->name}} {{$user->lastname}}</a><br/>
    @endforeach
@else
    None of your friends are online
@endif