@extends('layouts.mainStats')

@section('content')


<div class="container-fluid">

<div class="smokey p-5 border shadow">
<h1><span class="text-primary fa fa-cog fa-1x mr-3"></span>Settings</h1>
<hr>

<br>

    <settings-component class="mt-1" user="{{ Auth::user()->role }}"></settings-component>


</div>

</div>

@endsection
