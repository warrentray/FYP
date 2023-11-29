<title>Attendance</title>
@extends('layouts.master')
<script src="https://cdn.jsdelivr.net/npm/instascan@1.0.0"></script>
<script src="https://unpkg.com/html5-qrcode"></script>

@section('content')
@include('sweetalert::alert')
<div class="container text-dark">
    <div class="row">
        <div class="myform form">

            <div class="col-md-12 text-left mb-5">
                <h1><b>Attendance</b></h1>
                <div class="text-right ml-4">
                    <a href="{{ route('historyAttendance') }}"><button class=" btn btn-primary ">History
                            Attendance</button></a>
                </div>
                <hr>
                <h2>Station Name: {{$station->name}} </h2>
                <h2>Date: {{ now()->format('Y-m-d') }} ({{ now()->format('l') }}) </h2>
            </div>
        </div>
    </div>

    <form id="attendanceForm" action="{{ route('attendance.store') }}" method="post">
        @csrf
        <div class="container text-center">
            <!-- Disable Sign In button if already signed in -->
            <button id="signInBtn" class="btn btn-warning text mb-4" style="width: 40%; font-size: 24px; padding: 20px;"
                {{ $userAlreadySignedIn ? 'disabled' : '' }} onclick="confirmAction('sign in')">
                Sign In
            </button>
        </div>

        <div class="container text-center">
            <button id="signOutBtn" class="btn btn-warning text mt-4"
                style="width: 40%; font-size: 24px; padding: 20px;" {{ !$userAlreadySignedIn || $userAlreadySignedOut
                ? 'disabled' : '' }} onclick="confirmAction('sign out')">
                Sign Out
            </button>
        </div>
    </form>
</div>

<script>
    function confirmAction(action) {
        // Display a confirmation dialog
        var confirmation = confirm("Are you sure you want to " + action + "?" + date('H:i:s'));

        // If the user confirms, submit the form
        if (confirmation) {
            document.getElementById("attendanceForm").submit();
        }
    }
</script>

@endsection