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
<div id="tab" class="smokey border p-5 h-0 shadow">
<h1><span class="text-primary fa fa-plus fa-1x mr-3"></span>Create section</h1>
<hr>


    <form action="{{ route('sections.store') }}" method="post">
       {{ csrf_field() }}
       @method('POST')

    <div class="row">
        <div class="col-md-6">
            <label for="">Parent Section - <strong>(Leave blank to add to root)</strong></label>
            <div  class="form-inline">
                <input id="parent"  class="form-control w-75" required readonly>
                <button onclick="show_modal()" type="button" class="ml-2 btn btn-primary btn">
                    Sections
                </button>
                <input name="parent"  id="parent-hidden" type="hidden" value="0">



            </div>
        </div>

        <div class="col-md-6 h5">
            <div class="form-group">
                <label for="">Section title</label>
                <input  type="text" name="name" id="sectionName" class="form-control">
            </div>
        </div>
    </div>

    <input type="submit" class="btn btn-primary" value="Save">
    </form>
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
                <div style="max-height: 400px;" class="d-flex align-content-center table-responsive">
                    <table class="section-hover" id='example-basic-static'>
                        <tbody>
                            @php  echo $html @endphp
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

</div>



<script>

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

 $('#parent-hidden').val(pid);
 $('#parent').val(txt);

});



function show_modal()
{

    $('#modal').modal('show');

}



</script>

@endsection
