@extends('layouts.main')

@section('content')

<div class="container-fluid">
    @if (Session::has('success'))
                <div class="alert alert-warning alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ Session::get('success') }}</strong>
                </div>
                <br>
            @php
                Session::forget('success');
            @endphp
        @endif
    @php
        session(['previous' => url()->current()]);
    @endphp

    <div class="smokey mt-5 p-5 border shadow">
        <h1><span class="text-primary fa fa-snowflake-o fa-1x mr-3"></span><span>Snow groups</span>
            <span><a href="{{ route('snow.create') }}" class="pull-right btn btn-primary">New Entry</a></span>
        </h1>


        @if (count($entries) > 0)
        <div class="d-flex align-content-center table-responsive">

            <table id="snow-table" class="table table-inverse table-hover table-striped table-style">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th style="width:20%"></th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($entries as $entry)
                        <tr>
                            <td>{{ $entry->id }}</td>
                            <td>{{ $entry->title}}</td>
                            <td>{{ $entry->description}}</td>
                            <td>
                                <a style="display:none" href="{{ route('snow.edit', $entry->id) }}" class="snow-btn pull-right px-1 py-0 btn btn-info btn-sm"><i class="fa fa-edit" aria-hidden="true"></i></a>
                                <form action="{{ route('snow.destroy', $entry->id)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button style="display:none" class="snow-btn pull-right px-1 py-0 btn btn-danger mr-1 btn-sm" type="submit"><i class="fa fa-trash" aria-hidden="true"></i></button>
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


        <div style="" class="pagination">
            {{ $entries->links() }}
        </div>

        @else

        <div class="w-100 border-top p-5 d-flex justify-content-center">
            <h3>Looks like you need to add something!</h3>
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


$('#snow-table tbody tr').mouseenter(function(){   //SHow Hide view,edit,delete on hover\leave
   var row_index = $(this).index();

 var table = $("#snow-table")[0];
 $(this).css("cursor","pointer");

$(table.rows[row_index+1]).find('.snow-btn').show();

});

$('#snow-table tbody tr').mouseleave(function(){   //SHow Hide view,edit,delete on hover\leave
   var row_index = $(this).index();

 var table = $("#snow-table")[0];

$(table.rows[row_index+1]).find('.snow-btn').hide();

});

</script>

@endsection
