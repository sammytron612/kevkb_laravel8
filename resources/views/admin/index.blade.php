@extends('layouts.mainStats')

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
<div class="smokey mt-5 p-2 p-md-5 border shadow">
    <div class="row align-items-center">
        <div class="col px-4">
            <h1><i class="text-primary fa fa-user fa-1x mr-3"></i>Admin</h1>
        </div>
    </div>
<hr>


    <div class="ml-2 row d-flex">
        <div class="col-md-4 col-sm-12 p-0 p-md-2 mt-2 d-flex justify-content-center">
            <div class="card w-75">
                <a href=" {{ route('admin.invites') }} " class="stretched-link"><img class="card-img-top w-100" src="{{ asset('images/invites.png') }}" alt="invites"></a>
                    <div class="text-center card-body">

                            <!--Title-->
                            <h4 class="card-title">Invites</h4>
                            <!--Text-->
                            <p class="card-text">Quickly invite a colleague</p>
                            <!-- Provides extra visual weight and identifies the primary action in a set of buttons -->
                            <button class="text-center btn btn-outline-primary btn-sm">Go there</button>

                    </div>
            </div>
        </div>

        <div class="col-md-4 col-sm-12 p-0 p-md-2 mt-2">
            <div class="w-75 card">
                <a href=" {{ route('admin.usermanagement') }} " class="stretched-link"><img class="card-img-top" src="{{ asset('images/users.jpg') }}" alt="User Management"></a>
                    <div class="card-body text-center">
                            <!--Title-->
                            <h4 class="card-title">Users</h4>
                            <!--Text-->
                            <p class="card-text">User management</p>

                            <button class="btn btn-outline-primary btn-sm">Go there</button>
                    </div>
            </div>
        </div>

        <div class="col-md-4 col-sm-12 p-0 p-md-2 mt-2">
            <div class="w-75 card">
                <a href=" {{ route('admin.approvals') }} " class="stretched-link"><img class="card-img-top" src="{{ asset('images/approvals.png') }}" alt="invites"></a>
                    <div class="card-body text-center">
                        <!--Title-->
                        <h4 class="card-title">Approvals</h4>
                        <!--Text-->
                        <p class="card-text">Approve or reject articles</p>
                        <!-- Provides extra visual weight and identifies the primary action in a set of buttons -->
                        <button class="mx-auto btn btn-outline-primary btn-sm">Go there</button>
                    </div>
            </div>
        </div>

    </div>

    <div class="ml-2 row d-flex">

        <div class="col-md-4 col-sm-12 p-0 p-md-2 mt-2">
            <div class="w-75 card">
                <a href=" {{ route('notifications.create') }} " class="stretched-link"><img class="card-img-top" src="{{ asset('images/comment.jpg') }}" alt="User Management"></a>
                    <div class="text-center card-body">
                        <!--Title-->
                        <h4 class="card-title">Notifications</h4>
                        <!--Text-->
                        <p class="card-text">Send notifications to users</p>
                        <button class="btn btn-outline-primary btn-sm">Go there</button>
                    </div>
            </div>
        </div>
    </div>

</div>
</div>

<script>
$(document).ready(function() {

  $( ".card" ).hover(
  function() {
    $(this).addClass('shadow-lg').css('cursor', 'pointer');
  }, function() {
    $(this).removeClass('shadow-lg');
  }
);

// document ready
});


function stealth(id)
{
    var status = $('#' + id).is(":checked")

    $.ajax({
            type: "post",
            url: "{{ route('stealth.change') }}",
            data: {"_token": "{{ csrf_token() }}","status": status},
            dataType: "json",
            success: function (response) {

                console.log(response)

            }

        });
}
</script>

@endsection
