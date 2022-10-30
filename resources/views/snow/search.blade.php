@extends('layouts.mainStats')

@section('content')

<div class="container-fluid p-2 h-100">
    <snow-component></snow-component>
        <br>

        <div id="snowtable" class="p-5 smokey">
            <h1><span class="text-primary fa fa-snowflake-o fa-1x mr-3"></span><span>Snow groups</span>
            </h1>
            <table class="table table-hover table-striped table-style">
                <thead>
                    <tr>
                        <th>Ttle</th>
                        <th>Description</th>
                        <th>&nbsp</th>
                    </tr>
                </thead>
                    <tbody>
                        @foreach($entries as $entry)
                        <tr>
                            <td>{{ $entry->title}}</td>
                            <td>{{ $entry->description}}</td>
                            <td>&nbsp</td>
                        </tr>
                        @endforeach
                    </tbody>

            </table>

            <div style="" class="pagination">
                {{ $entries->links() }}
            </div>
        </div>

        <br>


</div>

@endsection
