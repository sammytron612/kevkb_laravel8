@extends('layouts.main1')

@section('content')


<div class="container-fluid">

<h1><span class="fa fa-eye fa-1x mr-3"></span>View article</h1>
<span style="font-size:20px">{{ $article->title }}<span>
<hr>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="">Title</label>
            <input type="text" value="{{ $article->title }}" id="" class="form-control" placeholder="" readonly>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label for="">Author</label>
            <input type="text" value="{{ $article->users->name }}" id="author" class="form-control" placeholder="" aria-describedby="helpId" readonly>
        </div>
     </div>
     <div class="col-md-3">
        <div class="form-group">
            <label for="">Date submitted</label>
            <input type="text" value="{{ $article->created_at->format('d-m-Y h:i:s') }}" id="author" class="form-control" placeholder="" aria-describedby="helpId" readonly>
        </div>
     </div>
</div>

<div class="row">
    <div class="col-md-6">
        <label for="">Section</label>
        <div  class="form-inline">

            <input id="section" value="{{ $article->sections->name }}" class="form-control w-100" required readonly>

        </div>
    </div>

    <div class="col-md-6">

             @if ($attachments)
                Attachment(s)

            @php
            echo "<br>";
            $count = 0;
             foreach($attachments as $attachment)
                {

                $attachment = rtrim($attachment, '"');
                $attachment = ltrim($attachment, '"');


                echo '<a href="' . $attachment . '"' . '><button class="mr-2 btn btn-success btn-sm">' . $names[$count] . '</button></a>';
                $count ++;
                }
            @endphp
            @endif

    </div>
</div>
<hr>

<div class="w-100">
    <div style="overflow-x:auto;white-space:nowrap" class="w-100 border p-5">
            @php echo $body->body @endphp
    </div>
</div>
<br>



</div>




@endsection
