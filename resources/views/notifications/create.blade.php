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
    <h1><span class="text-primary fa fa-bell fa-1x mr-3"></span>Notifications</h1>
    <hr>

    <form action="{{ route('notifications.send') }}" onsubmit="return validateForm()" method="post">
        {{ csrf_field() }}
        @method('POST')

     <div class="row">
         <div class="col-md-6">
             <label><h5>User(s)</h5></label>
             <div  class="form-group">
                 <select id="users"  name="users" class="form-control w-75" required>
                     <option default value="0">All users</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                 </select>
             </div>
         </div>
         <div class="col-md-6">
             <h5>Delivery channel</h5>
            <div class="custom-control custom-switch col-md-4">
                <input type="checkbox" name="notification" class="custom-control-input" id="notification">
                <label class="custom-control-label" for="notification"><h5>Notification</h5></label>
            </div>
            <div class="custom-control custom-switch col-md-4">
                <input type="checkbox" name="email" class="custom-control-input" id="email">
                <label class="custom-control-label" for="email"><h5>Email</h5></label>
            </div>
        </div>
     </div>


     <div class="row">
        <div class="col-md-6 h5">
            <div class="form-group">
                <label>Message</label>
                <textarea  type="text" name="message" id="message" required class="form-control"></textarea>
            </div>
        </div>
    </div>

     <input type="submit" class="btn btn-primary" value="Send">
     </form>

    </div>
</div>



<script>
    messaging.onMessage(function(payload) {
        const noteTitle = payload.notification.title;
        const noteOptions = {
            body: payload.notification.body,
            icon: payload.notification.icon,
        };
        new Notification(noteTitle, noteOptions);
    });

    function validateForm()
    {

        if($('#notification').prop("checked") == false && $('#email').prop("checked") == false )
        {
            alert('You need to specify atleast One delivery channel')
            return false

        } else
        {
            return true
        }


    }




</script>

@endsection
