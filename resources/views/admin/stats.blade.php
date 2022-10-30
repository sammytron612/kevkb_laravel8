@extends('layouts.mainStats')

@section('content')

<div class="container">

    <div class="smokey mt-2 p-5 border shadow">
        <h1><span class="text-primary fa fa-bar-chart fa-1x mr-3"></span>Stats
        </h1>
        <hr>

        <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="chart1-tab" data-toggle="tab" href="#chart1" role="tab" aria-controls="most viewed" aria-selected="true">Most viewed</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="chart2-tab" data-toggle="tab" href="#chart2" role="tab" aria-controls="greatest contributor" aria-selected="false">Greatest contributors</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="3hart3-tab" data-toggle="tab" href="#chart3" role="tab" aria-controls="highesst rated" aria-selected="false">Highest rated</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="chart4-tab" data-toggle="tab" href="#chart4" role="tab" aria-controls="recentyl added" aria-selected="false">Recently added</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div id="chart1" class="tab-pane active fade show col-12  p-5">
                <chart1-component></chart1-component>
            </div>

            <div id="chart2" class="tab-pane active fade show col-12 p-5">
                <chart2-component></chart2-component>
            </div>


            <div id="chart3" class="tab-pane  active fade show col-12 p-5">
                <chart3-component></chart3-component>
            </div>

            <div id="chart4" class="tab-pane active fade show col-12 p-5">
                <chart4-component></chart4-component>
            </div>

        </div>

    </div>
</div>

@endsection
