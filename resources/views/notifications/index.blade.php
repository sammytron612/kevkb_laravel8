@extends('layouts.mainStats')

@section('content')


<div class="container-fluid">

<div class="smokey p-5 border shadow">
<h1><span class="text-primary fa fa-bell fa-1x mr-3"></span>Notifications</h1>

@if($count > 0)
    <div class="d-flex align-content-center table-responsive">

        <table id="users-table" class="table table-inverse table-hover table-striped table-style">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Read</th>
                    <th>Date</th>
                    <th class="pull-right">Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($notifications as $notification)
                    <tr>
                        @if($notification->type == "App\Notifications\CommentAdded")
                        <td>A new comment has been added to '{{ $notification['data']['title'] }}' by {{ $notification['data']['author'] }}</td>
                        @endif
                        @if($notification->type == "App\Notifications\AdminNotification")
                        <td>A Message from KB</td>
                        @endif
                        @if($notification->type == "App\Notifications\NewArticle")
                        <td>Something new has beeen added</td>
                        @endif
                        @if($notification->type == "App\Notifications\ApprovalNotification")
                        <td>An article is pending approval</td>
                        @endif
                        <td>
                            @if($notification->unread())
                                <input onchange="checkBoxes(this.id)" id="{{ $notification->id }}" type="checkbox" name="read">
                            @else
                                <input onchange="checkBoxes(this.id)" id="{{ $notification->id }}" type="checkbox" checked aria-checked name="read">
                            @endif
                        </td>
                        <td>
                            {{ $notification->created_at->format('d-m-Y h:i:s') }}
                        </td>

                        <td>
                            <a id="d{{ $notification->id }}" onclick="view(this.id)" style="" href="javascript:void(0)" class="pull-right px-1 py-0 btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            <a id="v{{ $notification->id }}" style="" onclick="$(this).closest('tr').remove(); del(this.id)" href="javascript:void(0)" class="pull-right px-1 py-0 btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
@else
<div class="w-100 border-top p-5 d-flex justify-content-center">
    <h3>You have none</h3>
</div>
@endif
</div>

</div>

<!-- The Modal -->
<div class="modal" id="notification">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Current Notification</h4>

        </div>

        <!-- Modal body -->
        <div class="modal-body">
            @isset($current_notification)
                <input type="hidden" value="1" id="hidden">
                @if($current_notification->type == "App\Notifications\CommentAdded")
                    A new comment has been added to '{{ $current_notification['data']['title'] }}' by {{ $current_notification['data']['author'] }}
                    <br>
                    <br>
                    <p><q><i>{{ $current_notification['data']['comment'] }}</i></q></p>
                    <p>Thanks, KB</p>
                @endif
                @if($current_notification->type == "App\Notifications\AdminNotification")
                    A message From KB
                    <br>
                    <br>
                    <p><q><i>{{ $current_notification['data']['comment'] }}</i></q></p>
                    <p>Thanks, KB</p>
                @endif
                @if($current_notification->type == "App\Notifications\NewArticle")
                    <strong>Something new has been added</strong>
                    <br>
                    <br>
                    <p><q><i>Article {{ $current_notification['data']['title'] }} has been added to the section {{ $current_notification['data']['section'] }}</i></q></p>
                    <p>by <q><i>{{ $current_notification['data']['user'] }}</i></q></p>
                    <p>Thanks, KB</p>
                @endif
                @if($current_notification->type == "App\Notifications\ApprovalNotification")
                    <strong>An article is pending apporval</strong>
                <br>
                <br>
                <p><q><i>Article {{ $current_notification['data']['title'] }} is pending approval</i></q></p>
                <p>Added by <q><i>{{ $current_notification['data']['user'] }}</i></q></p>
                <p>Thanks, KB</p>
               @endif

            @endisset
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button onclick="modalClose()" type="button" class="btn btn-sm btn-primary">Close</button>
        </div>

      </div>
    </div>
  </div>

  <!-- The Modal -->
<div class="modal" id="notification-view">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Notification</h4>

        </div>

        <!-- Modal body -->
        <div id="modal-body" class="modal-body">

        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button onclick="modalClose()" type="button" class="btn btn-sm btn-primary">Close</button>
        </div>

      </div>
    </div>
  </div>



<script>

function checkBoxes(id)
{
    var ckb = $("#"+id).is(':checked');

    $.ajax({
        type: "post",
        url: "{{ route('notifications.checkbox') }}",
        data: {"_token": "{{ csrf_token() }}","id": id, "property": ckb},
        dataType: "json",
        success: function (response) {

            console.log(response)

        }

    });

}

function del(id)
{
    var id = id.substring(1);
    $.ajax({
        type: "post",
        url: "{{ route('notifications.delete') }}",
        data: {"_token": "{{ csrf_token() }}","id": id},
        dataType: "json",
        success: function (response) {


            console.log(response)
            Toast.fire({
                            icon: 'success',
                            title: 'Notification deleted successfully'
                            })

        }

    });


}

function view(id)
{

    var id = id.substring(1);
    $.ajax({
        type: "get",
        url: "{{ route('notifications.show') }}",
        data: {"_token": "{{ csrf_token() }}","id": id},
        dataType: "json",
        success: function (response) {
            let type = response.type
            let types = type.split("\\")
            console.log(response)

            if(types[2] === "CommentAdded")
            {
                let html = "<strong>A new comment has been added to '" + response.data.title + " by " + response.data.author + "</strong>"
                html += "<br>"
                html += "<p><q><i>" + response.data.comment + "</i></q></p>"
                $('#modal-body').html(html)
                $('#notification-view').modal('show');

            }
            if(types[2] === "AdminNotification")
            {
                let html = "<strong>A message from Admin</strong>"
                html += "<br>"
                html += "<br>"
                html += "<p><q><i>" + response.data.comment + "</i></q></p>"
                html += "<p>Thanks, admin</p>"
                $('#modal-body').html(html)
                $('#notification-view').modal('show');

            }
            if(types[2] === "NewArticle")
            {
                let html = "<strong>Something new has been added</strong>"
                html += "<br>"
                html += "<br>"
                html += "<p><q><i>Article " + response.data.title + " has been to the section " + response.data.section + "</i></q></p>"
                html += "<p>by <q>" + response.data.user + "<q></p>"
                html += "<p>Thanks, admin</p>"
                $('#modal-body').html(html)
                $('#notification-view').modal('show');

            }
            if(types[2] === "ApprovalNotification")
            {
                let html = "<strong>An article is pending approval</strong>"
                html += "<br>"
                html += "<br>"
                html += "<p><q><i>Article " + response.data.title + "</i></q> is pending approval" + "</p>"
                html += "<p>Added by <q>" + response.data.user + "<q></p>"
                html += "<p>Thanks, admin</p>"
                $('#modal-body').html(html)
                $('#notification-view').modal('show');

            }


            $.ajax({
            type: "post",
            url: "{{ route('notifications.checkbox') }}",
            data: {"_token": "{{ csrf_token() }}","id": id, "property": true},
            dataType: "json",
            success: function (response) {

                $( "#"+id ).prop( "checked", true );
        }

    });

        }

    });

}

function modalClose()
{
    $('.modal').modal('hide');

}

$(document).ready(function(){

if ($('#hidden').val() == 1)
 {$('#notification').modal('show');}


})

</script>

@endsection
