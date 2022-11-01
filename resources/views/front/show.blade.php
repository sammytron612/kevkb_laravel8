@extends('layouts.app')

@section('content')


<div class="container">

    <input id="avg_rating" type="hidden" value="{{ $article->avg_rating }}">
    <br>

<div class="smokey p-5 border shadow">

<h3><span class="fa fa-eye fa-1x mr-3"></span>View article<button onclick="history.back()" class="float-right btn btn-primary">Back</button></h3>

<hr>
<span class="ml-auto"><h3 class="text-primary">{{ $article->title }}</h3></span>
<hr>

    <div style="font-size:20px" class="row">

        <div class="col-md-6 col-sm-12">
            <span class="fa fa-user mr-1">&nbspAuthored by&nbsp{{ $article->users->name }} - </span>
            <span class="fa fa-eye mr-1">&nbsp Views&nbsp{{ $article->views }} </span>
        </div>

         <div class="col-md-6 col-sm-12">
            <span class="fa fa-calendar mr-1">&nbsp&nbspCreated&nbsp{{ \Carbon\Carbon::parse($article->created_at)->diffForHumans() }}</span>
         </div>
    </div>

    <div style="font-size:20px" class="row">
        <div class="col-md-6 col-sm-12">
            Section&nbsp-&nbsp<Span class="text-primary">{{ $article->sections->name }}</a>
        </div>
        <div class="col-md-3 col-sm-6">
            <span>{{ $article->kb }}</span>
        </div>
        <div class="col-md-3 col-sm-6">
            Rating&nbsp-&nbsp{{ $article->rating }}&nbspout of 5
        </div>
    </div>

    <div class="row mb-1">
        <div class="col-md-12">

                 @if ($attachments)
                 <hr>
                    <label><h5>Attachment(s)</h5></label>
                @endif
                @php

                 foreach($attachments as $attachment)
                    {
                    $name = explode("~",$attachment);
                    $name = rtrim($name[1], '"');
                    $attachment = rtrim($attachment, '"');
                    $attachment = ltrim($attachment, '"');

                    echo '<span class="pb-1 pr-1">';
                    echo '<a href="/attachments/download/' . $attachment . ' "><button class=" m-1 btn btn-success btn-sm">' . $name . '</button></a>';
                    echo "</span>";
                    }
                @endphp

        </div>
    </div>

    <hr>

        <div class="w-100">
            <div style="overflow-x:auto;white-space:normal" class="w-100 border p-5">
                    @php echo $body->body @endphp
            </div>
        </div>

    <br>
    @livewire('vote-component',['pct'=>$article->percentage, 'article'=>$article])
    
</div>
</div>
<script src="{{asset('js/rater.min.js')}}"></script>
<script>


var options = {
                max_value: 5,
                step_size: 0.5,
                readonly: true,
            }
            $(".rating").rate(options);




</script>

@endsection
