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


<div id="tab" class="mt-5 smokey border p-5 h-0">
    <h1><span class="text-primary fa fa-edit fa-1x mr-3"></span>Create Snow Group</h1>
    <hr>


    <form action="{{ route('snow.store') }}" method="post">
        {{ csrf_field() }}
       @method('POST')

        <div class="row">
            <div class="col-md-12">
                <label for=""><h4>Snow group title</h4></label>
                <div  class="form-inline">
                    <input class="form-control w-100" name="title" required>
                    @error('title')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-12">
                <label for=""><h4>Group description</h4></label>
                <div  class="form-inline">
                    <textarea class="form-control w-50" name="description"></textarea>
                </div>
            </div>
        </div>
        <div class="row mt-2 justify-content-left">
            <div class="col-md-6">
                <h4 class="">Tags</h4>
                @error('tags')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                <div id="tag-box" class="ml-2 border border-dark px-5 pb-5 pt-2 row justify-content-between">
                    <a href="javascript:void(0);" onclick="addInput()"><i class="fa fa-plus"></i></a>
                    <hr>


                </div>
                <input type="submit" class="float-right mt-2 btn btn-primary" value="Update">
            </div>
        </div>

    </form>
</div>


</div>


<script>

function addInput() {
    var html = '<input type="text" id="test" class="mt-1 form-control" name="tags[]" />'
    $('#tag-box').append(html)
  }


</script>
@endsection

