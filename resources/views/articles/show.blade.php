@extends('layouts.mainStats')

@section('content')


<div class="container-fluid">

    <input id="avg_rating" type="hidden" value="{{ $article->avg_rating }}">
    <br>

<div class="smokey p-5 border shadow">
@if ($article->scope == "public")
<h3><span class="text-primary fa fa-eye fa-1x mr-3"></span>View article<span><button type="button" class="pull-right btn btn-primary" data-toggle="modal" data-target="#modelId">
  Email
</button></span></h3>
@else
<h3><span class="fa fa-eye fa-1x mr-3"></span>View article</h3>
@endif
<hr>
<span class="ml-auto"><h3>{{ $article->title }}</h3></span>
<hr>

    <div style="font-size:20px" class="row">

        <div class="col-md-6 col-sm-12">
            <span class="fa fa-user mr-1">&nbspAuthored by&nbsp{{ $article->users->name }} - </span>
            <span class="fa fa-eye mr-1">&nbsp Views&nbsp{{ $article->views }} </span>
        </div>

         <div class="col-md-3 col-sm-12">
            <span class="fa fa-calendar mr-1">&nbsp&nbspCreated&nbsp{{ \Carbon\Carbon::parse($article->created_at)->diffForHumans() }}</span>
         </div>

         <div class="col-md-3 col-sm-12">
            <span>BTS&nbsp{{ $article->bts ? 'Yes' : 'No' }}</span>
         </div>
         
    </div>

    <div style="font-size:20px" class="row">
        <div class="col-md-6 col-sm-12">
            Section&nbsp-&nbsp<a href="{{ url("articles_index/$article->sectionid")}}">{{ $article->sections->name }}</a>
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
    <div style="color:black;font-family: 'Times New Roman', Times, serif; font-size:16px" class="row">
        <div class="form-group col-12">
            <div>Helpful?&nbsp&nbsp<button id="yes" class="vote btn btn-success btn-sm">Yes</button>
                <button id="no" class="vote btn btn-warning btn-sm">no</button>&nbsp
                {{ $article->percentage }}%&nbsp Found this article helpful
                <div class="d-flex justify-content-center">
                    <div  id="spinner1" style="display:none" class="spinner-border text-primary" role="status">
                      <span class="sr-only">Loading...</span>
                    </div>
                 </div>
            </div>
        </div>
    </div>

    <div style="color:black;font-family: 'Times New Roman', Times, serif; font-size:16px" class="row">
        <div class="form-group col-12">
            <h5 for="comment">Suggest an improvement</h5>
            <textarea class="form-control w-100" name="comment" id="comment"></textarea>
            Please rate this article
            <div class="d-flex justify-content-center">
                <div  id="spinner" style="display:none" class="spinner-border text-primary" role="status">
                  <span class="sr-only">Loading...</span>
                </div>
             </div>
            <div class="pt-2 pb-2 pl-0" id="rateYo"></div>
            <button onclick="ajax_comment()" type="text" class="mt-1 btn btn-primary">Submit</button>
        </div>

    </div>

    <hr>
    <div style="color:black;font-family: 'Times New Roman', Times, serif; font-size:16px" class="row mt-2">
            <div  class="form-group col-12">
                <label for="comment"><h4>Comments</h4></label>
                <div class="w-100">
                    @foreach($comments as $comment)
                    <div style="display:flex">
                        <div style="flex1"><b>{{ $comment->users->name }}</b> - {{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}&nbsp-&nbsp</div>
                        <div style="" class='rating' data-rate-value='{{ $article->rating }}'></div>
                    </div>
                    @if($comment->comment)
                    <i>"{{ $comment->comment }}"</i>
                    @endif
                    <br>
                    <br>
                    @endforeach
                </div>
            </div>
    </div>



<!-- Modal -->
<div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Email Article</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('email.article') }}" method="post">
                @csrf
                <div class="d-flex justify-content-center">
                    <input class="w-75" type="email" name="email" required>
                </div>
                <input id="articleid" type="hidden" name="id" value="{{ $article->id }}">
                <input type="hidden" name="title" value="{{ $article->title }}">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Send</button>
                </form>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


</div>
</div>
<script src="{{asset('js/rater.min.js')}}"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
<script>


var options = {
                max_value: 5,
                step_size: 0.5,
                readonly: true,
            }
            $(".rating").rate(options);

function vote(vote){

    $('#spinner1').show();
    if(vote =="yes"){vote = 1} else {vote = 0}
    var articleid = $('#articleid').val();
    $.ajax({
    type: "post",
    url: "{{ route ('articles.ratingset') }}",
    dataType: "json",
    data: {"_token": "{{ csrf_token() }}", "articleid": articleid,"vote": vote},
    success: function (response) {
        $('#spinner1').hide();
        console.log(response)
        if(response == "success"){
            Swal.fire({
            title: 'Thanks for your vote',
            showClass: {
                popup: 'animate__animated animate__fadeInDown'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutUp'
            }
        })
        } else
        {
            Swal.fire({
            icon: "error",
            title: 'You have voted for this 3 times!!',
            showClass: {
                popup: 'animate__animated animate__fadeInDown'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutUp'
            }
        })

        }

        }
        });


}
function ajax_comment()
{

    $('#spinner').show();
    var articleid = $('#articleid').val();
    var comment = $('#comment').val();
    var rating = $("#rateYo").rateYo("rating");
    

    $.ajax({
    type: "post",
    url: "{{ route ('comments.addComment') }}",
    dataType: "json",
    data: {"_token": "{{ csrf_token() }}","rating": rating, "articleid": articleid,"comment": comment},
    success: function (response) {
        $('#spinner').hide();
     
        if(response == "success"){
            Swal.fire({
            title: 'Thanks for your comment',
            showClass: {
                popup: 'animate__animated animate__fadeInDown'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutUp'
            }
        })
        $('#comment').val('')
        $("#rateYo").rateYo("option", "rating", "0");
        }

        }
        });
}

$(document).ready(function(){

    $(".vote").click(function(){

    vote(this.id)
});

});

$(document).ready(function(){

 $("#rateYo").rateYo({
   rating: 0,
   halfStar: true,
   starWidth: "20px"
 });

});



</script>

@endsection
