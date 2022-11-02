@extends('layouts.mainStats')

@section('content')


<div class="container-fluid">

    <div class="smokey p-5 border shadow">
    <h1><span class="text-primary fa fa-cog fa-1x mr-3"></span>Settings</h1>
    <hr>

    <br>

        @livewire('settings-component')


    </div>

</div>

@endsection
