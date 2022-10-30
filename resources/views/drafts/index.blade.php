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

<div class="smokey mt-5 p-5 border shadow">
<h1><span class="text-primary fa fa-save fa-1x mr-3"></span>Drafts
</h1>
   @if (count($drafts) > 0)
   <div class="table-responsive-md">
    <table id="article-table" class="table table-inverse table-hover table-striped table-style">
        <thead>
            <tr>
                <th>Title</th>
                <th>Section</th>
                <th>Created</th>
                <th style="width:20%"></th>
            </tr>
            </thead>
            <tbody>
                @foreach($drafts as $draft)
                <tr>
                    <td>{{ $draft->title }}</td>
                    <td>{{ $draft->sections->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($draft->created_at)->diffForHumans() }}</td>
                    <td>
                        <a style="display:none" href="{{ route('drafts.edit', $draft->id) }}" class="pull-right mr-1 px-1 py-0 btn btn-primary btn-sm"><i class="fa fa-edit" aria-hidden="true"></i></a>
                        <a style="display:none" href="javascript:void(0)" onclick="remove(this)" class="mr-1 pull-right px-1 py-0 btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            <form action="{{ route('drafts.destroy', $draft->id) }}" method="post">
                                @method('DELETE')
                                {{ csrf_field() }}
                            </form>
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
      {{ $drafts->links() }}
</div>
@else

<div class="w-100 border-top p-5 d-flex justify-content-center">
    <h3>You have none</h3>
</div>
@endif

</div>
</div>



<script>
function remove(e)
{
  Swal.fire({
    showClass: {
    popup: 'animate__animated animate__fadeInDown'
    },
  title: 'Are you sure?',
  text: "You won't be able to revert this!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
  if (result.value) {
    $(e).parent().find('form').submit();
  } else {return}
})

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
