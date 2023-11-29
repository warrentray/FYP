<title>Edit Leave</title>
@extends('layouts.master')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">
@section('content')
</head>

<body>
    <div class="container-fluid text-dark">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold" style="font-size:20px; color:black;"><b>Edit leave</b></h6>
            </div>

            <div class="card-body">
                <div class="row mt-6">
                    <div class="row mt-2 ml-2 mb-4">
                        <a href="{{ route('dashApply') }}">
                            <button class="btn btn-warning btn-circle btn-xl"
                                style="width: 50px; height: 50px; border-radius: 35px; padding: 6px 0px;">
                                <span><i class="fa fa-arrow-left"></i></span>
                            </button>
                        </a>
                    </div>
                </div>
                <form id="applyLeaveForm" class="blockquote" method="post"
                    action="{{ route('updateLeave', ['id' => $staffLeave->id]) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Leave Type:</label>
                        <div class="form-group col-md-3">
                            <select name="leaveType" id="inputState" class="form-control"
                                onchange="updateAvailableDays()">
                                <option selected>Choose leave type</option>
                                @foreach($leaveTypes as $leaveType)
                                @if(strcmp($leaveType->leave_type, "Maternity Leave") != 0 || session('user')['gender']
                                === 'Female')
                                @php
                                $i=0;
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
                                <option value="{{ $leaveType->leave_type }}"
                                    data-leave-type="{{ $leaveType->leave_type }}"
                                    data-leave-id="{{ $leaveType->leave_id }}" class="{{ $leaveType->totalNumber }}"
                                    @if($staffLeave->leaveType == $leaveType->leave_type) selected @endif>
                                    {{ $leaveType->leave_type }}
                                </option>

                                @endif
                                @endforeach
                            </select>

                            @error('inputState')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <label for="staticEmail" class="col-sm-3 col-form-label">Available Day:</label>
                        <div class="form-group col-md-3">
                            <label for="day" id="availableDays">Select the leave type</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Start Date:* </label>
                        <div class="form-group col-md-3">
                            <div class='input-group date'>
                                <input placeholder="Select date" type="date" id="startDate" name="startDate"
                                    class="form-control" value="{{ $staffLeave->applyStartDate }}" disabled>

                                {{-- <input placeholder="Select date" type="date" id="startDate" name="startDate"
                                    class="form-control" disabled> --}}
                            </div>
                            @error('startDate')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <label for="staticEmail" class="col-sm-3 col-form-label">End Date:* </label>
                        <div class="form-group col-md-3">
                            <div class='input-group date'>
                                <input placeholder="Select date" type="date" id="endDate" name="endDate"
                                    class="form-control" value="{{ $staffLeave->applyEndDate}}" disabled>

                                {{-- <input placeholder="Select date" type="date" id="endDate" name="endDate"
                                    class="form-control" disabled> --}}
                            </div>
                            @error('endDate')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Leave Reason:</label>
                        <div class="form-group col-md-9">
                            <textarea class="form-control" id="leaveReason" name="leaveReason" rows="6"
                                placeholder="Enter leave reason">{{ $staffLeave->reason }}</textarea>

                            @error('leaveReason')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-2">
                        <button type="submit" class="btn btn-warning" data-bs-toggle="button" autocomplete="off">Edit
                            leave</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function updateAvailableDays() {
            var selectedLeaveType = $("#inputState option:selected").val();
            $("#startDate, #endDate").prop("disabled", false);
            $("#availableDays").text(selectedLeaveType);
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Get the <select> element
            var leaveTypeSelect = document.getElementById('inputState');

            // Add onchange event listener
            leaveTypeSelect.addEventListener('change', function () {
                // Get the selected option
                var selectedOption = leaveTypeSelect.options[leaveTypeSelect.selectedIndex];

                // Get the class name of the selected option
                var selectedClassName = selectedOption.className;
                
                // Enable the date inputs
                $("#startDate, #endDate").prop("disabled", false);
                // Update the #availableDays label with the class name
                document.getElementById('availableDays').textContent =  selectedClassName;
            });
        });
    </script>
    @endsection
</body>