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
@if ($errors->any())
                    @foreach ($errors->all() as $error)
                    <div class="alert alert-danger alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{$error}}</strong>
                    </div>
                    @endforeach
        @endif
<div class="smokey mt-5 p-5 border shadow">
<h1><span class="text-primary fa fa-sticky-note fa-1x mr-3"></span>Sections  @can('isViewer')@else <span><a href="{{ route('sections.create') }}" class="pull-right btn btn-primary">New Section</a></span>@endcan</h1>
@if($html)
<strong>Double click to view articles for that section</strong>
<div class="table-responsive-md">
    <table class="table table-inverse table-hover table-style" id="section-table">
    <thead>
    <tr><th>Section Title</th><th></th><th># Of Articles</th><th  style="width:30%"></th></tr>
    </thead>
    <tbody>
    @php
    echo $html;
    @endphp
    </tbody>
    </table>
</div>
<br>
<div style="" class="pagination">
      {{ $sections->links() }}
</div>
@else

<div class="w-100 border-top p-5 d-flex justify-content-center">
    <h3>Looks like you need to add a section!</h3>
</div>
@endif
</div>

<div>

<script>

$('#section-table tbody tr').dblclick(function(e){   //SHow Hide view,edit,delete on hover\leave

    var id=$(this).attr('id');
    var url = '{{ url("articles_index") }}';
    url += '/' + id

    window.location.href = url

});

$('#section-table tbody tr').mouseenter(function(){   //SHow Hide view,edit,delete on hover\leave
   var row_index = $(this).index();

 var table = $("#section-table")[0];
 $(this).css("cursor","pointer");

$(table.rows[row_index+1]).find('.section-btn').show();

});

$('#section-table tbody tr').mouseleave(function(){   //SHow Hide view,edit,delete on hover\leave
   var row_index = $(this).index();

 var table = $("#section-table")[0];

$(table.rows[row_index+1]).find('.section-btn').hide();

});

$("#section-table").treetable({ expandable: true, initialState: 'collapsed' });

</script>

@endsection
