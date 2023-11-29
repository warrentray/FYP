@extends('layouts.master')
<title>Add Staff</title>

@section('content')
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
<link href="https://fonts.googleapis.com/css?family=Kaushan+Script" rel="stylesheet">
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
    integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

<body>
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    @include('sweetalert::alert')

    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold" style="font-size:20px; color:black;"><b>Add staff</b></h6>
            </div>
            <div class="container">
                <div class="row mt-6">
                    <div class="row mt-4 ml-2 mb-4">
                        <a href="{{ route('manageStaff') }}">
                            <button class="btn btn-warning btn-circle btn-xl"
                                style="width: 50px; height: 50px; border-radius: 35px; padding: 6px 0px;">
                                <span><i class="fa fa-arrow-left"></i></span>
                            </button>
                        </a>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-md-5 mx-auto">
                        <div id="first" class="border p-4">
                            <div class="myform form">
                                <div class="col-md-12 text-center">
                                    <h2><b>Add Staff</b></h2>
                                </div>
                                <form method="POST" action="{{ route('addStaff') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="fullname">Full Name</label>
                                        <input type="text" name="fullname"
                                            class="form-control @error('fullname') is-invalid @enderror" id="fullname"
                                            aria-describedby=" " placeholder="Enter full name">
                                        @error('fullname')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email address</label>
                                        <input type="email" name="email"
                                            class="form-control @error('email') is-invalid @enderror" id="email"
                                            aria-describedby="emailHelp" placeholder="Enter email">
                                        <p>Example: example@gmail.com</p>

                                        @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="fullname">Identity card </label>
                                        <input type="text" name="ic"
                                            class="form-control @error('ic') is-invalid @enderror" id="ic"
                                            aria-describedby=" " placeholder="Enter identity card">
                                        <p>Example: xxxxxx-xx-xxxx</p>

                                        @error('ic')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="gender">Gender</label>
                                        <input type="hidden" name="gender" value="{{ $defaultgender }}">

                                        <select class="form-control" name="gender" id="gender">
                                            @foreach($genders as $gender)
                                            <option value="{{ $gender }}">{{ $gender }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col">
                                                <label for="Password" class="mr-3">Password</label>
                                            </div>
                                            <div class="col-auto">
                                                <input type="checkbox" class="mr-2 " id="showPassword"
                                                    onclick="myFunction()">
                                                <label class="form-check-label" for="showPassword">Show Password</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="Password"
                                            class="form-control @error('Password') is-invalid @enderror" id="Password"
                                            aria-describedby="" placeholder="Enter password">
                                        @error('Password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="Confirm Password">Confirm Password</label>
                                        <input type="password" name="confirm_password" id="confirm_password"
                                            class="form-control @error('confirm_password') is-invalid @enderror"
                                            aria-describedby=" " placeholder="Enter confirm password">

                                        @error('confirm_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="stationName">Station</label>
                                        <select class="form-control" name="stationName" id="stationName">
                                            <option selected disabled>Choose station</option>
                                            @foreach($stations as $station)
                                            <option value="{{ $station->id }}">{{ $station->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <div class="dropdown">
                                            <label for="shift_type">Shift </label>
                                            <select name="shiftType" class="form-control">
                                                <option selected disabled>Choose shift</option>
                                                <option value="morning" style="display: none;">Morning</option>
                                                <option value="afternoon" style="display: none;">Afternoon</option>
                                                <option value="night" style="display: none;">Night</option>
                                                @error('shift_type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </select>

                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label for="bonus_type">Bonus Type</label>
                                        <input type="hidden" name="bonusType" value="{{ $defaultbonusType }}">

                                        <select class="form-control @error('bonus_type') is-invalid @enderror"
                                            name="bonus_type" id="bonus_type">
                                            @foreach($bonusTypes as $bonusType)
                                            <option value="{{ $bonusType }}">{{ $bonusType }}</option>
                                            @endforeach
                                            @error('bonus_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="basic_salary">Basic salary (RM)</label>
                                        <input type="text" name="basic_salary"
                                            class="form-control @error('basic_salary') is-invalid @enderror"
                                            id="basic_salary" aria-describedby=" " placeholder="Enter basic salary ">
                                        @error('basic_salary')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="bonus_amount">Bonus amount (RM)</label>
                                        <input type="text" name="bonus_amount"
                                            class="form-control @error('bonus_amount') is-invalid @enderror"
                                            id="bonus_amount" aria-describedby=" " placeholder="Enter bonus amount">
                                        @error('bonus_amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-8 text-center mb-1 mx-auto">
                                        <button type="submit" class=" btn btn-block mybtn btn-success  tx-tfm">Sign Up
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="{{ asset('login.js') }}"></script>
<script src="{{ asset('login.css') }}"></script>
<script>
    function myFunction() {
            var x = document.getElementById("Password");
            var y = document.getElementById("confirm_password");
            if (x.type === "password") {
                x.type = "text";
                y.type = "text";
            } else {
                x.type = "password";
                y.type = "password";
            }
        }
</script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    var stationOperationHours = {
        @foreach($stations as $station)
            '{{ $station->id }}': '{{ $station->operationHours }}',
        @endforeach
    };

    $(document).ready(function() {
        // Add an event listener for the station dropdown change event
        $('select[name="stationName"]').change(function() {
            // Get the selected station ID
            var stationId = $(this).val();

            // Set the hidden input value
            $('#station_id').val(stationId);

            // Check station operation hours
            var operationHours = stationOperationHours[stationId];
            if (operationHours && operationHours.toLowerCase() === '24 hours') {
                // Show all three shift options
                $('select[name="shiftType"] option').show();
            } else {
                // Only show morning and afternoon shifts
                $('select[name="shiftType"] option').hide();
                $('select[name="shiftType"] option[value="morning"]').show();
                $('select[name="shiftType"] option[value="afternoon"]').show();
            }
        });
        function getSelectedStationId() {
        return selectedStationId;
    }
});
</script>



@endsection