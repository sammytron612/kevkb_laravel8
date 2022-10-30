@extends('layouts.mainStats')

@section('content')

<div class="container-fluid">

    <div class="smokey mt-2 p-5 border shadow">
    <h1><span class="text-primary fa fa-comments fa-1x mr-3"></span>Comments
    </h1>
    <hr>

        @php $i=0;@endphp
        @foreach($comments as $comment)
            <div class="mt-5 chat-container">
                <div id="id-{{ $i }}" class="chat-sender msg"><i>{{$comment->name}}</i>&nbsp-&nbspCommented on&nbsp<i>{{$comment->title}}</i>&nbsp-&nbsp{{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans()}}
                    <div class="chatmsg"><strong>{{$comment->comment}}</strong></div>
                    <div class="rating" data-rate-value={{ $comment->rating }}></div>
                </div>
            </div>
        @php $i++;@endphp
        @endforeach
        <input id="hidden" type="hidden" value="{{ $i }}">
        <br>
        <div style="" class="pagination-lg">
            {{ $comments->links() }}
        </div>
    </div>


</div>
<script src="{{asset('js/rater.min.js')}}"></script>
<script>

$(".rating").rate(options);
var options = {
    max_value: 5,
    step_size: 0.5,
    readonly: true,
}

    let color = ['red', 'Blue','gray','black','green','lightgreen','purple','lightblue','crimson','turquiose']
    let limit = $('#hidden').val()
    for (i = 0; i < limit; i++)
    {
        let r = Math.floor(Math.random() * 10);
        $('#id-'+i).css("background-color", color[r])
    }

</script>


@endsection
