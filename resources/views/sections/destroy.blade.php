@extends('layouts.main')

@section('content')


<div class="container-fluid">
@if (Session::has('success'))
               <div class="alert alert-success alert-block">
                  <button type="button" class="close" data-dismiss="alert">×</button>
                  <strong>{{ Session::get('success') }}</strong>
               </div>
               <br>
           @php
               Session::forget('success');
           @endphp
@endif
<div class="smokey p-5 border shadow">
<h1><span class="text-primary fa fa-trash fa-1x mr-3"></span>Delete section</h1>
<hr>

<br>
    <form action="{{ route('sections.destroy') }}" onsubmit="return validate()" method="post">
       {{ csrf_field() }}
       @method('POST')

        <div class="row">
            <div class="col-md-12">
                <input id="sectionid" type="hidden" name="sectionid" value="{{ $section->id }}">
                <label><h5 style="font-weight:normal">Delete section `<strong>{{ $section->name }}</strong>` and all its children(and articles)</h5></label>
                <input id="del1" type="radio" name="choice" value="0">
                <label><h5 style="font-weight:normal">Delete section `<strong>{{ $section->name }}</strong>` and articles, move all child sections and articles to another section</h5></label>
                <input id="del2" type="radio" name="choice" value="1">
            </div>
        </div>
        @if ($errors->any())
                    @foreach ($errors->all() as $error)
                    <div class="alert alert-danger alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{$error}}</strong>
                    </div>
                    @endforeach
        @endif
        <div id="parent" style="display:none" class="row">
            <div class="col-md-6">

                <label for="">Choose section - <strong>(Leave blank to add to root)</strong></label>
                <div  class="form-inline">
                    <input id="parent-title"  name="parent" class="form-control w-75 readonly required">
                    <button onclick="show_modal()" type="button" class="ml-2 btn btn-primary btn">
                        Sections
                    </button>
                    <input name="parentid"  id="parent-hidden" type="hidden" value="0">
                </div>
            </div>


        </div>
        <br>
        <div>
            <input type="submit" class="btn btn-primary" value="Delete">
        </div>
    </form>
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sections</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                 <table class="section-hover" id='example-basic-static'>
                     <tbody>
                        @php echo $html @endphp
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<script>


function validate()
{


    if ($("#del1").is(":checked") || $("#del2").is(":checked"))
    {

    if (confirm('Are you sure you want to do this?'))
    {
        return true;
    }
    else
        {
            return false;
        }

    }
     else
    {
        alert("Choose an option");
        return false;
    }

}

$( "#del2" ).click(function() {
  $('#parent').show();
});

$( "#del1" ).click(function() {
  $('#parent').hide();
});

$("#example-basic-static").treetable({ expandable: true, initialState: 'collapsed' });

$(".section-hover tr td" ).hover(function() {

    $(this).css('background-color','lightgray');

});

$(".section-hover tr td").mouseleave(function() {

    $(this).css('background-color','white');

});

$(".section-hover tr td").click(function() {

$(".section-hover tr td").css('font-weight','Normal');
$(this).css('font-weight','bold')

var pid = $(this).parent().attr("id");

var txt = $(this).text();




$('#parent-title').val(txt);
$('#parent-hidden').val(pid);


});



function show_modal()
{

    $('#modal').modal('show');

}



</script>

@endsection
