@extends('layouts.mainStats')

@section('content')

<div id="wrapper" class="container-fluid p-2 h-100">
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
<!--<form action="/searches/search" method="post">
    @csrf
    <input name="search">
    <button type="submit">go</button>
</form> -->
    <search-component v-bind:user='{!! Auth::user()->toJson() !!}'></search-component>
</div>

@endsection
