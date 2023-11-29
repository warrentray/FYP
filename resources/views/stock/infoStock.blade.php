<title>Stock Management</title>
<!--@if(!session('user')){
return redirect('../login')->with('error', 'Please login to do the further action.');
}else if(session('user') && session('user')->role!='Manager'){
return redirect('../login')->with('error', 'Illegitimate Access!');
}
@endif-->
@extends('layouts.master')
@include('sweetalert::alert')

@section('content')
<style>
    html {
        -webkit-font-smoothing: antialiased !important;
        -moz-osx-font-smoothing: grayscale !important;
        -ms-font-smoothing: antialiased !important;
    }

    body {
        font-family: 'Open Sans', sans-serif;
        font-size: 16px;
        color: #555555;
    }

    .md-stepper-horizontal {
        display: table;
        width: 100%;
        margin: 0 auto;
        background-color: #FFFFFF;
        box-shadow: 0 3px 8px -6px rgba(0, 0, 0, .50);
    }

    .md-stepper-horizontal .md-step {
        display: table-cell;
        position: relative;
        padding: 24px;
    }



    .md-stepper-horizontal .md-step:active {
        border-radius: 15% / 75%;
    }

    .md-stepper-horizontal .md-step:first-child:active {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }

    .md-stepper-horizontal .md-step:last-child:active {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }



    .md-stepper-horizontal .md-step:first-child .md-step-bar-left,
    .md-stepper-horizontal .md-step:last-child .md-step-bar-right {
        display: none;
    }

    .md-stepper-horizontal .md-step .md-step-circle {
        width: 30px;
        height: 30px;
        margin: 0 auto;
        background-color: #999999;
        border-radius: 50%;
        text-align: center;
        line-height: 30px;
        font-size: 16px;
        font-weight: 600;
        color: #FFFFFF;
    }

    .md-stepper-horizontal.green .md-step.active .md-step-circle {
        background-color: #00AE4D;
    }

    .md-stepper-horizontal.orange .md-step.active .md-step-circle {
        /* background-color: #F96302; */
        background-color: #00AE4D;

    }

    .md-stepper-horizontal .md-step.active .md-step-circle {
        background-color: rgb(33, 150, 243);
    }

    .md-stepper-horizontal .md-step.done .md-step-circle:before {
        font-family: 'FontAwesome';
        font-weight: 100;
        content: "\f00c";
    }

    .md-stepper-horizontal .md-step.done .md-step-circle *,
    .md-stepper-horizontal .md-step.editable .md-step-circle * {
        display: none;
    }

    .md-stepper-horizontal .md-step.editable .md-step-circle {
        -moz-transform: scaleX(-1);
        -o-transform: scaleX(-1);
        -webkit-transform: scaleX(-1);
        transform: scaleX(-1);
    }

    .md-stepper-horizontal .md-step.editable .md-step-circle:before {
        font-family: 'FontAwesome';
        font-weight: 100;
        content: "\f040";
    }

    .md-stepper-horizontal .md-step .md-step-title {
        margin-top: 16px;
        font-size: 16px;
        font-weight: 600;
    }

    .md-stepper-horizontal .md-step .md-step-title,
    .md-stepper-horizontal .md-step .md-step-optional {
        text-align: center;
        color: rgba(0, 0, 0, .26);
    }

    .md-stepper-horizontal .md-step.active .md-step-title {
        font-weight: 600;
        color: rgba(0, 0, 0, .87);
    }

    .md-stepper-horizontal .md-step.active.done .md-step-title,
    .md-stepper-horizontal .md-step.active.editable .md-step-title {
        font-weight: 600;
    }

    .md-stepper-horizontal .md-step .md-step-optional {
        font-size: 12px;
    }

    .md-stepper-horizontal .md-step.active .md-step-optional {
        color: rgba(0, 0, 0, .54);
    }

    .md-stepper-horizontal .md-step .md-step-bar-left,
    .md-stepper-horizontal .md-step .md-step-bar-right {
        position: absolute;
        top: 36px;
        height: 1px;
        border-top: 1px solid #DDDDDD;
    }

    .md-stepper-horizontal .md-step .md-step-bar-right {
        right: 0;
        left: 50%;
        margin-left: 20px;
    }

    .md-stepper-horizontal .md-step .md-step-bar-left {
        left: 0;
        right: 50%;
        margin-right: 20px;
    }
</style>
<link href="{{asset('admin/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
@include('sweetalert::alert')


<div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold  " style="font-size:20px; color:black;"><b>Stock Information</b>
            </h6>
        </div>
        <div class=" card-body">
            <div class="   mb-4">
                <div class="md-stepper-horizontal orange">
                    <div class="row mt-2 ml-2 mb-4">
                        <div>
                            <a href="{{ route('viewStock') }}">
                                <button class="btn btn-warning btn-circle btn-xl"
                                    style="width: 50px; height: 50px; border-radius: 35px; padding: 6px   0px;">
                                    <span><i class="fa fa-arrow-left"></i></span>
                                </button>
                            </a>
                        </div>
                    </div>
                    <div
                        class="md-step @if ($delivery->status === 'On Road' || $delivery->status === 'Pending'|| $delivery->status === 'Delivered' ) active @else inactive   @endif">
                        <div class="md-step-circle"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="30"
                                fill="currentColor" class="bi bi-file-post" viewBox="0 0 16 16">
                                <path
                                    d="M4 3.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-8z" />
                                <path
                                    d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2zm10-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1z" />
                            </svg></div>
                        <div class="md-step-title">Being scheduled </div>
                        <div class="md-step-bar-left"></div>
                        <div class="md-step-bar-right"></div>
                    </div>
                    <div
                        class="md-step @if ($delivery->status === 'On Road' || $delivery->status === 'Delivered') active @else @if ($delivery->status === 'Pending'  ) inactive @endif  @endif">

                        <div class="md-step-circle">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="30" align-items:center
                                fill="currentColor" class="bi bi-truck" viewBox="0 0 16 16">
                                <path
                                    d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5v-7zm1.294 7.456A1.999 1.999 0 0 1 4.732 11h5.536a2.01 2.01 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456zM12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12v4zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                            </svg>
                        </div>
                        <div class="md-step-title">Order Shipping </div>
                        <div class="md-step-bar-left"></div>
                        <div class="md-step-bar-right"></div>
                    </div>
                    <div
                        class="md-step @if ($delivery->status === 'Delivered') active  @else @if ($delivery->status === 'On Road' || $delivery->status === 'On Road' ) inactive @endif @endif  ">
                        <div class="md-step-circle"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="30"
                                fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                <path
                                    d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z" />
                            </svg>

                        </div>
                        <div class="md-step-title">Delivery Arrive</div>
                        <div class="md-step-bar-left"></div>
                        <div class="md-step-bar-right"></div>
                    </div>


                </div>
            </div>





            <div class="row">
                <div class="col-sm-12 ml-2 mb-5">
                    <div class="card">
                        <div class="card-body">
                            @if ($delivery)
                            <h5 class="card-title"><b>Billing Date :</b> {{ $delivery->date }}</h5>
                            <h5 class="card-title"><b>Delivery Id :</b> {{ $delivery->id }}</h5>
                            <h5 class="card-title"><b>Delivery Location :</b> {{ $stationAddress }}</h5>
                            @else
                            <h5 class="card-title"><b>Delivery not found.</b> </h5>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive ml-2 mr-2 mb-5">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tank number</th>
                            <th>Fuel Type</th>
                            <th>Quality (L)</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $i = 1; ?>

                        @if ($delivery)
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{ $delivery->tank_number }}</td>
                            <td>{{ $delivery->petrol_type }}</td>
                            <td>{{ $delivery->quality }}</td>
                        </tr>
                        @else
                        <tr>
                            <td colspan="4">Delivery not found.</td>
                        </tr>
                        @endif

                    </tbody>

                </table>
            </div>
            @endsection