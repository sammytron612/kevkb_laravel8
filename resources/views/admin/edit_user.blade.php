@extends('layouts.main')

@section('content')


<div class="container-fluid">

<div class="smokey p-5 border shadow">
    <h1><i class="text-primary fa fa-edit fa-1x mr-3"></i>User details</h1>
    <hr>
<div class="border shadow p-5">
    <form action="{{ route('admin.update_user',$user->id) }}" method="post">
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
                <input id="name" class="form-control" type="email" value="{{ $user->email }}" readonly name="email">
            </div>
        </div>
    </div>

    <div class="mt-5 row">
        <div class="col-md-6">
            <div class="w-50 form-group">
              <label for="role"><h4>Role</h4></label>
              <select class="form-control" name="role" id="role">
                <option @if ($user->role == "viewer" ) selected @endif value="viewer">Viewer</option>
                <option @if ($user->role == "editor" ) selected @endif value="editor">Editor</option>
                <option @if ($user->role == "admin" ) selected @endif value="admin">Admin</option>
              </select>
            </div>
        </div>

        <div class="col-md-6">

            <div class="form-group">
                <label for=""><h4>Status</h4></label>
                <select class="custom-select" name="status" id="status">

                    @if ($user->status == "active")
                        <option selected value="active">Active</option>
                        <option value="disabled">Disabled</option>
                    @else
                        <option selected value="disabled">Disabled</option>
                        <option value="active">Active</option>
                    @endif

                </select>
            </div>
        </div>
    </div>


    <div class="row mt-2">
        <div class="col-md-6">
            <div class="w-50 form-group">
              <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>

    </form>
</div>

<hr>

<div class="ml-2 row border shadow p-5 col-12 col-md-6">
<H5 class="">Lastest logins for {{ $user->name }}</h5>


        <table id="users-table" class=" mt-2 table table-sm table-hover table-condesed">
            <thead>
                <tr>
                    <th>Login date</th>
                    <th>IP</th>

                </tr>
                </thead>
                <tbody>
                    @foreach($logins as $login)
                    <tr>

                        <td>{{ \Carbon\Carbon::parse($login->last_login)->toDayDateTimeString() }}</td>
                        <td>{{ $login->ip  }}</td>
                    </tr>
                    @endforeach
                </tbody>
        </table>

    </div>


</div>

</div>

@endsection
