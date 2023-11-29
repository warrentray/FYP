<title>Create training</title>
@extends('layouts.master')
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script> <!-- Add Moment.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js">
</script>
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">



@section('content')

@include('sweetalert::alert')


<div class="container-fluid text-dark">

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold" style="font-size:20px; color:black;"><b>Create new training</b></h6>
        </div>
        <div class="card-body">
            <!-- Update your viewTraining.blade.php file -->

            <form action="{{ route('trainings.store') }}" method="POST">
                @csrf

                <div class="form-group row">
                    <label for="training_name" class="col-sm-3 col-form-label">Training Name:</label>
                    <div class="col-md-9">
                        <input type="text" name="training_name" id="training_name" class="form-control"
                            aria-describedby=" " placeholder="Enter training name">
                        @error('training_name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>


                <div class="form-group row">
                    <label for="location" class="col-sm-3 col-form-label">Location:</label>
                    <div class="col-md-9">
                        <input type="text" name="location" id="location" class="form-control" aria-describedby=" "
                            placeholder="Enter training location">
                        @error('location')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="start_date" class="col-sm-3 col-form-label">Start Date & Time * :</label>
                    <div class="col-md-3">
                        <input type="datetime-local" name="start_date" id="start_date" class="form-control" />
                        @error('start_date')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <label for="end_date" class="col-sm-3 col-form-label">End Date & Time *:</label>
                    <div class="col-md-3">
                        <input type="datetime-local" name="end_date" id="end_date" class="form-control" />
                        @error('end_date')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="description" class="col-sm-3 col-form-label">Description:</label>
                    <div class="col-md-9">
                        <textarea class="form-control" id="description" class="form-control" aria-describedby=" "
                            name="description" rows="6" placeholder="Enter training description"></textarea>
                        @error('description')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-2">
                    <button type="submit" class="btn btn-warning" autocomplete="off">Add a new training</button>
                </div>
            </form>

        </div>
    </div>
</div>


<script type="text/javascript">
    $(function () {
        $('#datetimepicker').datetimepicker();
    });
</script>


@endsection