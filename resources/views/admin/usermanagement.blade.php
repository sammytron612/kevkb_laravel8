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
<h1><span class="text-primary fa fa-user fa-1x mr-3"></span>Users
</h1>


<div class="d-flex align-content-center table-responsive">

    <table id="users-table" class="table table-hover table-striped table-style">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
                <th>Last login</th>
                <th>Role</th>
                <th style="width:20%"></th>
            </tr>
            </thead>
            <tbody>

                @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email}}</td>
                    <td>{{ $user->status}}</td>
                    <td> @if($user->login->last() !== null)
                         {{  \Carbon\Carbon::parse($user->login->last()->last_login)->toDayDateTimeString()  }} @endif
                        </td>
                    <td>{{ $user->role  }}</td>
                    <td>
                        <a style="display:none" href="{{ route('admin.edit_user', $user->id) }}" class="pull-right px-1 py-0 btn btn-info btn-sm"><i class="fa fa-edit" aria-hidden="true"></i></a>
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
<div style="" class="pagination-sm">
    {{ $users->links() }}
</div>
</div>

</div>

<script>


$('#users-table tbody tr').mouseenter(function(){   //SHow Hide view,edit,delete on hover\leave
   var row_index = $(this).index();

 var table = $("#users-table")[0];

$(table.rows[row_index+1]).find('a').show();

});

$('#users-table tbody tr').mouseleave(function(){   //SHow Hide view,edit,delete on hover\leave
   var row_index = $(this).index();

 var table = $("#users-table")[0];

$(table.rows[row_index+1]).find('a').hide();

});


</script>

@endsection
