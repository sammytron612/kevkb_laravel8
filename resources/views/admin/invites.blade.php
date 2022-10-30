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
        <h1><span class="text-primary fa fa-envelope fa-1x mr-3"></span>Invites
        </h1>
        <hr>
        <br>
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="{{ route('email') }}">
                @csrf
                    @error('email')
                    <div class="alert alert-danger alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        {{ $message }}
                    </div>
                    @enderror
                    <label><h3>Email</h3></label>&nbsp
                    <input class="h5 w-50 p-2" name="email" type="email" required>&nbsp
                    <button class="btn btn-primary btn-lg" type="submit">Send</a></button>
                <form>
            </div>
        </div>
        <br>
        <br>
    </div>
</div>

@endsection
