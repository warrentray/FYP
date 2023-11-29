@extends('layouts.master')

@section('content')
@include('sweetalert::alert')

<div class="container-fluid text-dark">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold" style="font-size:20px; color:black;"><b>Edit Training</b></h6>
        </div>
        <div class="card-body">

            <form action="{{ route('trainings.update', ['id' => $training->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <!-- Use the PUT method for updates -->

                <div class="form-group row">
                    <label for="training_name" class="col-sm-3 col-form-label">Training Name:</label>
                    <div class="col-md-9">
                        <input type="text" name="training_name" id="training_name" class="form-control"
                            value="{{ $training->training_name }}" placeholder="Enter training name">
                        @error('training_name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="location" class="col-sm-3 col-form-label">Location:</label>
                    <div class="col-md-9">
                        <input type="text" name="location" id="location" class="form-control" aria-describedby=" "
                            value="{{ $training->location }}" placeholder="Enter training location">
                        @error('location')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="start_date" class="col-sm-3 col-form-label">Start Date & Time * :</label>
                    <div class="col-md-3">
                        <input type="datetime-local" name="start_date" value="{{ $training->start_date }}"
                            id="start_date" class="form-control" />
                        @error('start_date')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <label for="end_date" class="col-sm-3 col-form-label">End Date & Time *:</label>
                    <div class="col-md-3">
                        <input type="datetime-local" name="end_date" value="{{ $training->end_date }}" id="end_date"
                            class="form-control" />
                        @error('end_date')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="description" class="col-sm-3 col-form-label">Description:</label>
                    <div class="col-md-9">
                        <textarea class="form-control" id="description" name="description" rows="6">
                       {{ $training->description }}
                        </textarea>
                        @error('description')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
        </div>

        <div class="d-grid gap-1 d-md-flex justify-content-md-end mb-5 mr-2">
            <button type="submit" class="btn btn-warning" autocomplete="off">Update exiting training</button>
        </div>
        </form>

    </div>
</div>
</div>

@endsection