<title>Dashboard Leave</title>

@extends('layouts.master')

@section('content')
<style>
    .btn-primary,
    .btn-primary:active,
    .btn-primary:visited {
        background-color: #6046FF !important;
    }

    .btn-second,
    .btn-second:active,
    .btn-second:visited {
        background-color: #6930c3;
        color: white;

    }

    .btn-Third,
    .btn-Third:active,
    .btn-Third:visited {
        background-color: #0077b6;
        color: white;

    }

    .btn-second:hover {
        background-color: #9f86c0 !important;
        transition: all 1s ease;
        -webkit-transition: all 1s ease;
        -moz-transition: all 1s ease;
        -o-transition: all 1s ease;
        -ms-transition: all 1s ease;
        color: white;
    }

    .btn-Third:hover {
        background-color: #48cae4 !important;
        transition: all 1s ease;
        -webkit-transition: all 1s ease;
        -moz-transition: all 1s ease;
        -o-transition: all 1s ease;
        -ms-transition: all 1s ease;
        color: white;
    }

    .btn-primary:hover {
        background-color: #7d6af8 !important;
        transition: all 1s ease;
        -webkit-transition: all 1s ease;
        -moz-transition: all 1s ease;
        -o-transition: all 1s ease;
        -ms-transition: all 1s ease;
    }
</style>

<div class="card shadow mb-5  mt-3">
    <div class="container-fluid">
        <div class="card-header p-3 >
        <h6 class=" m-0 font-weight-bold " style=" font-size:20px; color:black;"><b>Leave dashboard
            </b>
            </h6>
        </div>
        <div class="card shadow mb-4">
            <div class="text-left ml-4 mt-3 ">
                <a href="{{ route('applyLeave') }}"><button class="btn btn-primary ">Apply Now</button></a>
                <a href="{{ route('medicalClaims') }}"><button class=" btn btn-second ">Medical Claim</button></a>
                <a href="{{ route('leaveHistory') }}"><button class=" btn btn-Third ">Leave History</button></a>
                <a href="{{ route('claimHistory') }}"><button class=" btn btn-Third ">Claim History</button></a>


            </div>
            <div class="row">
                @foreach($leaveTypes as $leaveType)

                @if(strcmp($leaveType->leave_type, "Maternity Leave")!=0 || session('user')['gender'] === 'Female')

                <div class="col-lg-4 col-md-6 p-5">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h2 class="card-title text-dark">{{ $leaveType->leave_type }}</h2>
                                </div>

                                <div class="col-auto">
                                    @php
                                    foreach ($userLeaveBalances as $userLeave) {
                                    if (strcmp($leaveType->leave_type, $userLeave->leaveType) == 0) {
                                    if (strcmp($userLeave->status, 'Pending') == 0) {
                                    $leaveType->totalNumber -= $userLeave->totalLeave;
                                    if (strcmp($userLeave->status, 'Approved') == 0) {
                                    $leaveType->totalNumber -= $userLeave->totalLeave;
                                    }
                                    }elseif (strcmp($userLeave->status, 'Approved') == 0) {
                                    $leaveType->totalNumber -= $userLeave->totalLeave;
                                    if (strcmp($userLeave->status, 'Pending') == 0) {
                                    $leaveType->totalNumber -= $userLeave->totalLeave;
                                    }
                                    }
                                    }
                                    }
                                    @endphp
                                    <div class="stat text-primary">

                                        <h1 class="ml-0 mt-5 mb-3">{{ $leaveType->totalNumber }}</h1>
                                    </div>
                                </div>
                            </div>
                            <h4 class="ml-4 mt-1 mb-1">Currently Available</h4>
                        </div>
                    </div>
                </div>

                @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection