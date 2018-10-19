@foreach($comments as $comment)
    @include('bits.comment')
@endforeach
@if($moreAvailable)
    <button class="btn btn-secondary btn-sm float-right" onclick="
            $.ajax({
                url: '{{route('getcomments', ['id' => $id, 'start' => $start])}}',
                cache: false,
                success: function(html){
                $('#comments{{$id}}').append(html);
            }});$(this).remove();
            ">Load more comments</button>
@endif