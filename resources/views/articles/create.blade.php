@extends('layouts.mainStats')

@section('content')


<div class="container-fluid ">
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
<div class="smokey p-5 mt-5 border shadow">
<h1><span class="text-primary fa fa-newspaper-o fa-1x mr-3"></span>New article</h1>
<hr>


    <form onsubmit="return validate_form()" action="{{ route('articles.store') }}" method="post" enctype="multipart/form-data" multiple="multiple">
       @method('POST')
       {{ csrf_field() }}

    <input type="hidden" id="images" name="images" value="~">
    <div class="row h5">
        <div class="col-md-6">
            <div class="form-group">
            @error('title')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
                <label for="">Title</label>
                <input type="text" value="{{ old('title') }}" name="title" id="" class="form-control" placeholder="" required>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="">Tags</label>
                <input type="text"  name="tags" value="{{ old('tags') }}" id="tags" class="form-control" placeholder="" aria-describedby="helpId">
            </div>
         </div>
    </div>

    <div class="row h5">
        <div class="col-md-6">
            <label for="">Section</label>
            <div  class="form-inline form-group-sm">
                @error('sectionid')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <input id="section" value="{{ old('section') }}" class="form-control w-75 mr-2" disabled required>
                <button onclick="show_modal()" type="button" class="btn btn-primary btn">
                    Sections
                </button>
                <input name="sectionid" value="{{ old('sectionid') }}" id="section-hidden" type="hidden" required>

            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                @error('attachments')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <label for="">Attachment(s)</label>
                <input type="file" name="attachments[]" id="attachments" class="form-control" multiple='multiple'>
            </div>
        </div>
    </div>

     <div class="row mb-2 h5">
        <div class="col-md-3">
            <div class="form-group">
                <label for="">Scope</label>
                <select class="custom-select" name="scope" id="">
                    <option selected value="private">Private</option>
                    <option value="public">Public</option>
                </select>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="">Status</label>
                <select class="custom-select" name="publish" id="">
                  <option selected value="1">Publish</option>
                  <option value="0">Draft</option>
                </select>
            </div>
        </div>
     </div>


    <textarea id="editor" name="body">

    </textarea>
    <br>
    <button type="submit" class="btn btn-primary btn-lg">Publish</button>

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
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

</div>

</div>
<script src="https://cdn.tiny.cloud/1/d3utf658spf5n1oft4rjl6x85g568jj7ourhvo2uhs578jt9/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>


function validate_form()
{

 var count = $("#attachments").get(0).files.length;

 if (count > 3)
 {
     alert("A max of 3 files can be uploaded")
     return false;

 } else

 {return true}



}


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
      plugins: 'template autoresize autolink image fullscreen imagetools emoticons link lists hr paste media table',
      toolbar: 'insert undo redo fullscreen fontsizeselect alignleft aligncenter alignright alignjustify h1 h2 bold italic numlist bullist image link emoticons hr paste table',
      contextmenu: "link image table paste",
      content_style: 'textarea { padding: 20px; }',
      templates: [
    {title: 'Some title 1', description: 'Some desc 1', content: 'My content'},
    {title: 'Some title 2', description: 'Some desc 2', url: 'development.html'},
  ],
      autoresize_bottom_margin: 50,

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
               $('#images').val(image)

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
