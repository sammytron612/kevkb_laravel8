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
<h1><span class="text-primary fa fa-edit fa-1x mr-3"></span>Edit article</h1>
<span style="font-size:20px" class="ml-auto">{{ $article->title }}<span>
<hr>

    <form onsubmit="return validate_form()" action="{{ route('articles.update',$article->id) }}" enctype="multipart/form-data" method="post">
       {{ csrf_field() }}
       @method('PUT')
    <input type="hidden" id="images" name="images" value="~">
    <div class="row h5">
        <div class="col-md-6">
            <div class="form-group">
            @error('title')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
                <label for="">Title</label>

                <input type="text" value="{{ $article->title }}" name="title" id="" class="form-control" placeholder="" required>
            </div>
        </div>

        <div class="col-6 h5">
            <div class="form-group">
                <label for="">Tags</label>
                <input type="text" value="{{ $article->tags }}" name="tags" id="tags" class="form-control" placeholder="" aria-describedby="helpId">
            </div>
         </div>
    </div>

    <div class="row h5">
        <div class="col-md-6">
            <label for="">Section</label>
            <div class="form-inline">
                @error('sectionid')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <input id="section" value="{{ $article->sections->name }}" class="form-control w-75" required readonly>
                <button onclick="show_modal()" type="button" class="ml-2 btn btn-primary btn">
                    Sections
                </button>
                <input name="sectionid" value="{{ $article->sectionid }}" id="section-hidden" type="hidden" required>
            </div>
        </div>

        <div class="col-md-6 h5">
            <div class="form-group">
                    <div style="display:none" id="att1">
                         Attachment(s) - <strong>Click to delete</strong>
                    </div>
                    <div style="display:none" id="att2">
                        Attachment(s)
                    </div>
                    <div style="display:none" id="att3">
                         Attachment(s) - <strong>Click to delete</strong>
                    </div>
                    <div class="mt-2" id="inp-div">
                        <input type="file" name="attachments[]" id="attachments" class="form-control" multiple='multiple'>
                    </div>

                    <input id="attachCount" type="hidden" value="{{ $article->attachCount }}">

                <div class="mt-3">
                @php
                $count = 0;
                 foreach($attachments as $attachment)
                    {
                    $name = explode("~",$attachment);
                    $name = $name[1];
                    //echo '<a href="articles/download/' . $attachment . '"><button class="btn btn-success btn-sm">' . $name . '</button>';
                    echo '<button type="button" id="at-' . $count . '" class="mr-2 mb-2 btn btn-sm btn-danger">' . $name . '</button>';
                    echo '<input type="hidden" id="inp-' . $count . '" value="' . $attachment . '">';
                    $count ++;
                    }
                @endphp
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-2 h5">
        <div class="col-md-3">
            <div class="form-group">
                <label for="">Scope</label>
                <select class="custom-select" name="scope" id="">
                @if ($article->scope == 'private')
                    <option selected value="private">Private</option>
                    <option value="public">Public</option>
                @else
                    <option value="private">Private</option>
                    <option selected value="public">Public</option>
                @endif
                </select>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="">Status</label>
                <select class="custom-select" name="publish" id="">
                    @if($article->status == 0)
                        <option value="1">Publish</option>
                        <option selected value="0">Draft</option>
                    @else
                        <option selected value="1">Publish</option>
                        <option value="0">Draft</option>
                    @endif
                </select>
            </div>
        </div>
     </div>

    <textarea class="p-5" id="editor" name="body">
       @php echo $body->body @endphp
    </textarea>
    <br>
    <button type="submit" class="btn btn-primary btn-lg">Update</button>

    </form>

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
                            @php echo $html @endphp
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
</div>

</div>
<script src="https://cdn.tiny.cloud/1/d3utf658spf5n1oft4rjl6x85g568jj7ourhvo2uhs578jt9/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>

function input_div()
{

      if ($('#attachCount').val() == 0)
    {
        $('#att2').show();
        $('#att1').hide();
        $('#att3').hide();
        $('#inp-div').show();

        return
    }

     if ($('#attachCount').val() < 3)
    {

        $('#att1').show();
        $('#att2').hide();
        $('#att3').hide();
        $('#inp-div').show();
        return
    }

    if ($('#attachCount').val() == 3)
    {
        $('#att3').show();
        $('#att2').hide();
        $('#att1').hide();
        $('#inp-div').hide();
        ;

        return
    }
}

$( document ).ready(function() {
    input_div();
});

function validate_form()
{

 var count = $("#attachments").get(0).files.length;


 count = +count + +$('#attachCount').val();

 if (count > 3)
 {
     alert("A max of 3 attachments can be stored!")
     return false;
     exit;

 } else

 {return true}

}


$('.btn-danger').click(function(){

if (!confirm('Are you sure you want to delete this?')) {
  return
}


$('#'+this.id).remove();
var v = $('#attachCount').val();
v--;
$('#attachCount').val(v);


input_div();

var inp_id = this.id.split('-');
inp_id = inp_id[1];
var inp = $('#inp-'+inp_id).val();




var CSRF_TOKEN  =  "{{csrf_token()}}";
var postData ={
                    _token : CSRF_TOKEN,
                     inp:  inp,
                     btn_id: inp_id,
                     id: {{ $article->id }}
              }

$.ajax({
    type: "post",
    url: "{{ route('attachments.delete_attach') }}",
    data: postData,
    dataType: "json",
    success: function (response) {



    }

  });
});


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

 $('#section-hidden').val(pid);
 $('#section').val(txt);

});

function show_modal()
{

    $('#modal').modal('show');

}

       tinymce.init({

        height : "600",
        selector: '#editor',
        relative_urls : false,
        document_base_url : "{{ url('/') }}",
      plugins: 'template autoresize autolink image fullscreen imagetools emoticons link lists hr paste media table',
      toolbar: 'insert undo redo fullscreen fontsizeselect alignleft aligncenter alignright alignjustify h1 h2 bold italic numlist bullist image link emoticons  hr paste table',
        contextmenu: "link image table paste",
        content_style: 'textarea { padding: 20px; }',
        templates: [
        {title: 'Some title 1', description: 'Some desc 1', content: 'My content'},
        {title: 'Some title 2', description: 'Some desc 2', url: 'development.html'},
    ],
      images_upload_handler: function (blobInfo, success, failure) {
           var xhr, formData;
           xhr = new XMLHttpRequest();
           xhr.withCredentials = false;
           xhr.open('POST', '{{ route("image.upload") }}');
           var token = '{{ csrf_token() }}';
           xhr.setRequestHeader("X-CSRF-Token", token);
           xhr.onload = function() {
               var json;
               if (xhr.status != 200) {
                   failure('HTTP Error: ' + xhr.status);
                   return;
               }
               json = JSON.parse(xhr.responseText);

               if (!json || typeof json.location != 'string') {
                   failure('Invalid JSON: ' + xhr.responseText);
                   return;
               }

               var image = $("#images").val()

               image += (json.location);
               image += "~";
               $('#images').val(image);

               success(json.location);
           };
           formData = new FormData();
           formData.append('file', blobInfo.blob(), blobInfo.filename());
           xhr.send(formData);
       }

    });

  $("#example-basic-static").treetable({ expandable: true, initialState: 'collapsed' });

</script>

@endsection
