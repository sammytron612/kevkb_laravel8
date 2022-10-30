@extends('layouts.main')

@section('content')


<div class="container-fluid">


<div id="tab" class="mt-5 smokey border p-5 h-0">
    <h1><span class="text-primary fa fa-edit fa-1x mr-3"></span>Edit Snow Group</h1>
    <hr>


    <form action="{{ route('snow.update', $entry->id) }}" method="post">
       {{ csrf_field() }}
       @method('patch')

        <div class="row">
            <div class="col-md-12">
                <label for=""><h4>Snow group title</h4></label>
                <div  class="form-inline">
                    <input  value="{{ $entry->title }}"class="form-control w-100" name="title" required>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-12">
                <label for=""><h4>Goup description</h4></label>
                <div  class="form-inline">
                    <textarea class="w-50 form-control" name="description">{{ $entry->description }}</textarea>
                </div>
            </div>
        </div>
        <div class="row mt-2 justify-content-left">
            <div class="col-md-6">
                <h4 class="">Tags</h4>
                <div id="tag-box" class="ml-2 border border-dark p-5 row justify-content-between">
                    <a href="javascript:void(0);"onclick="addInput()"><i class="fa fa-plus"></i></a>
                    @php
                        $tags = explode(" ",$entry->tags);
                    @endphp
                    @foreach($tags as $tag)
                        @if($tag != "")
                        <input class="mt-2 form-control" name="tags[]" value="{{ $tag }}"/>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        <input type="submit" class="mt-2 btn btn-primary" value="Update">
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
