@extends('layouts.main')

@section('content')


<div class="container-fluid">

<div class="smokey mt-5 p-5 border shadow">
    <h1><i class="text-primary fa fa-user fa-1x mr-3"></i>Profile</h1>
    <hr>
<div class="border shadow p-5">
    <form action="{{ route('profile.update') }}" onsubmit="return validateForm()" method="post" enctype="multipart/form-data">
       {{ csrf_field() }}


    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="name"><h4>Name</h4></label>
                <input id="name" class="form-control" type="text" value="{{ $user->name }}" readonly name="name">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="name"><h4>Email</h4></label>
                <input id="email" class="form-control" type="email" value="{{ $user->email }}" readonly name="email">
            </div>
        </div>
    </div>

    <div class="mt-5 row">
        <div class="col-md-6">
            <label for="role"><h4>Push notifications&nbsp&nbsp
                @if($user->push_notifications)
                    <input onchange="toggle_push()" name="phoneCheck" type="checkbox" id="checkPush" checked>
                @else
                    <input onchange="toggle_push()" name="phoneCheck" type="checkbox" id="checkPush">
                @endif
                </h4>
            </label>
        </div>

        <div class="col-md-6">
            <label for="checkpw"><h4>Change password&nbsp&nbsp
                <input onchange="toggle_pw()" name="pwcheck" type="checkbox" id="checkpw">
                </h4>
            </label>
            <div id="password" class="d-none">
                <div class="form-group">
                    <label for="pw1"><h6>Password</h6></label>
                <input class="form-control" type="password" name="pw1" id="pw1" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="pw2"><h6>Confirm password</h6></label>
                    <input class="form-control" type="password" name="pw2" id="pw2" autocomplete="off">
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5 row">
        <div class="col-md-6 d-flex">
            @if($user->avatar)
                <div><img style="width: 52px; height: 52px;" class="rounded-circle" src="/storage/avatars/{{ $user->avatar }}"></img></div>
            @else
                <div class="avatar bg-@php echo(Session::get('avatarColour')); @endphp">@php echo(Session::get('avatarI')); @endphp</div>
            @endif

            <label class="ml-2" for="role"><h4>Avatar upload</h4>
            <input class="form-control" type="file" name="avatar" id="avatar">
            @error('avatar')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>


    <div class="row mt-2 mr-2">
        <div class="form-group col">
              <button type="submit" class="float-right btn btn-primary">Update</button>
            </div>
        </div>
    </div>

    </form>
</div>

</div>


<script>

if("{{ Auth::user()->push_notifications }}")
    {
        if (Notification.permission !== "granted")
        {
            initFirebaseMessagingRegistration()
        }
    }

    function deleteToken()
    {
        $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: '{{ route("deleteToken") }}',
                    type: 'POST',
                    dataType: 'JSON',
                    success: function (response) {
                        alert('Push notifications disabled.');
                    },
                    error: function (err) {
                        console.log('Error'+ err);
                    },
                });

    }

    function initFirebaseMessagingRegistration() {
            messaging
            .requestPermission()
            .then(function () {
                return messaging.getToken()
            })
            .then(function(token) {
                console.log(token);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: '{{ route("saveToken") }}',
                    type: 'POST',
                    data: {
                        token: token
                    },
                    dataType: 'JSON',
                    success: function (response) {
                        alert('Push notifications enabled.');
                    },
                    error: function (err) {
                        console.log('Error'+ err);
                    },
                });

            }).catch(function (err) {
                console.log('User Chat Token Error'+ err);
            });
     }

    messaging.onMessage(function(payload) {
        const noteTitle = payload.notification.title;
        const noteOptions = {
            body: payload.notification.body,
            icon: payload.notification.icon,
        };
        new Notification(noteTitle, noteOptions);
    });




    function toggle_pw(id)
    {
        if($('#checkpw').is(':checked'))
        {
            $('#password').addClass("d-block");

        } else
        {
            $('#password').removeClass("d-block");
            $('#password').addClass("d-none");

        }
    }

    function toggle_push()
    {
        if ($('#checkPush').is(':checked'))
        {
            initFirebaseMessagingRegistration()
        } else
        {
            deleteToken()
        }


    }

    function validateForm()
    {
        if($('#checkpw').is(':checked'))
        {
            pw1 = $('#pw1').val()
            pw2 = $('#pw2').val()

            if(pw1 != pw2)
            {
                alert("passwords do not match")
                $('#pw1').addClass('border-danger')
                $('#pw2').addClass('border-danger')
                return false
            }

            if(pw1.length < 8)
            {
                alert("password needs to be atleast 8 charcters")
                $('#pw1').addClass('border-danger')
                $('#pw2').addClass('border-danger')
                return false
            }
        }

        return true
    }

</script>

@endsection
