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

<div class="mt-5 smokey p-5 border shadow">
<h1><span class="text-primary fa fa-check fa-1x mr-3"></span>Approvals
</h1>
   @if (count($articles) > 0)
   <div class="table-responsive-md">
    <table id="article-table" class="table table-inverse table-hover table-style">
        <thead>
            <tr>
                <th>Title</th>
                <th>Section</th>
                <th>Author</th>
                <th style="width:20%"></th>
            </tr>
            </thead>
            <tbody>
                @foreach($articles as $article)
                <tr>
                    <td>{{ $article->title }}</td>
                    <td>{{ $article->sections->name }}</td>
                    <td>{{ $article->users->name  }}</td>
                    <td>
                        <a style="display:none" href="{{ route('admin.approval_show', $article->id) }}" class="pull-right mr-1 px-1 py-0 btn btn-primary btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></a>
                    </td>

                </tr>
                @endforeach
            </tbody>
                <tfoot>
                    <tr>
                        <th colspan="5"></th>
                    </tr>
                </tfoot>
        </table>
    </div>
<br>
<div style="" class="pagination-lg">
      {{ $articles->links() }}
</div>
@else

<div class="w-100 border-top p-5 d-flex justify-content-center">
    <h3>Nothing to approve</h3>
</div>
@endif

</div>
</div>



<script>
function remove(e)
{
    if (confirm('Do you want to delete this?'))
    {
        $(e).parent().find('form').submit();
    } else
    {
        return;
    }


}

$('#article-table tbody tr').mouseenter(function(){   //SHow Hide view,edit,delete on hover\leave
   var row_index = $(this).index();

 var table = $("#article-table")[0];

$(table.rows[row_index+1]).find('a').show();

});

$('#article-table tbody tr').mouseleave(function(){   //SHow Hide view,edit,delete on hover\leave
   var row_index = $(this).index();

 var table = $("#article-table")[0];

$(table.rows[row_index+1]).find('a').hide();

});




</script>

@endsection
