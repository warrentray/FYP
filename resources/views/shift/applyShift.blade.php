<!-- resources/views/shift/apply.blade.php -->

@extends('layouts.master')

@section('content')
@if (session('message'))
<div class="alert alert-success">
    {{ session('message') }}
</div>
@endif
@include('sweetalert::alert')

<div class="container text-dark">
    <div class="card shadow mb-5">
        <div class="card-header py-4">
            <h6 class="m-0 font-weight-bold" style="font-size:20px; color:black;"><b>Apply shift for staff </b></h6>
        </div>
        <div class="card-body">
            <div class="row mt-4">
                <div class="row mt-2 ml-2">
                    <a href="{{ route('petrolDetail') }}">
                        <button class="btn btn-warning btn-circle btn-xl"
                            style="width: 50px; height: 50px; border-radius: 35px; padding: 6px 0px;">
                            <span><i class="fa fa-arrow-left"></i></span>
                        </button>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5 mx-auto">
                    <div id="first" class="border p-4">
                        <div class="myform form">
                            <form action="{{ route('applyShiftReq') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <div class="dropdown">
                                        <label for="station_id">Station Name</label>
                                        <select name="station_id" class="form-control">
                                            <option selected disabled>Choose station</option>
                                            @foreach($stations as $station)
                                            <option value="{{ $station->id }}">{{ $station->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="dropdown">
                                        <label for="staff_id">Staff Name</label>
                                        <select name="staff_id" class="form-control">
                                            <option selected>Choose staff</option>
                                            @foreach($stations as $station)
                                            @foreach($station->user as $staff)
                                            <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                                            @endforeach
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="dropdown">
                                        <label for="shift_type">Shift</label>
                                        <select name="shift_type" class="form-control">
                                            <option selected>Choose shift</option>
                                            <option value="morning" style="display: none;">Morning</option>
                                            <option value="afternoon" style="display: none;">Afternoon</option>
                                            <option value="night" style="display: none;">Night</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-8 text-center mb-1 mx-auto">
                                    <button type="submit" class="btn btn-block mybtn btn-success tx-tfm">Reschedule
                                        Shift</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    // Preload staff data for all stations
    
    var staffData = {
        @foreach($stations as $station)
            '{{ $station->id }}': {!! json_encode($station->user) !!},
        @endforeach
    };
    var stationOperationHours = {
        @foreach($stations as $station)
            '{{ $station->id }}': '{{ $station->operationHours }}',
        @endforeach
    };
    $(document).ready(function() {
        // Add an event listener for the station dropdown change event
        $('select[name="station_id"]').change(function() {
            // Get the selected station ID
            var stationId = $(this).val();

            // Hide all staff options
            $('select[name="staff_id"] option').hide();
 
            // Show the staff options for the selected station
            $.each(staffData[stationId], function(index, staff) {
                $('select[name="staff_id"] option[value="' + staff.id + '"]').show();
            });

            // Check station operation hours
            var operationHours = stationOperationHours[stationId];
            if (operationHours && operationHours.toLowerCase() === '24 hours') {
                // Show all three shift options
                $('select[name="shift_type"] option').show();
            } else {
                // Only show morning and afternoon shifts
                $('select[name="shift_type"] option').hide();
                $('select[name="shift_type"] option[value="morning"]').show();
                $('select[name="shift_type"] option[value="afternoon"]').show();
            }
        });
    });
</script>
@endsection