<title>New type petrol</title>
@extends('layouts.master')

@section('content')
@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif
@include('sweetalert::alert')

<div class="container   text-dark ">
    <!-- Edit Your Personal Setting -->
    <div class="card shadow mb-5">
        <div class="card-header py-4>
            <h6 class=" m-0 font-weight-bold " style=" font-size:20px; color:black;"><b>Add new petrol </b>
            </h6>
        </div>
        <div class="card-body">
            <div class=" row mt-4 ">
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
                            <form method="POST" action="{{ route('addPetrol') }}" id="petrolForm"
                                onsubmit="captureSelectedStation()">
                                @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Petrol Name</label>
                                    <input type="text" name="fuelname"
                                        class="form-control @error('fuelname') is-invalid @enderror" id="fuelname"
                                        aria-describedby="" placeholder="Enter fuel name">
                                    @error('fuelname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <div class="dropdown">
                                        <label for="exampleInputGender">Petrol type</label>
                                        <select class="form-control" name="petrol" @error('petrol') is-invalid
                                            @enderror" id="petrol">
                                            @foreach ($petrolTypes as $value => $label)
                                            <option value="{{ $value }}">{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('petrol')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Price (RM):</label>
                                    <input type="text" name="price"
                                        class="form-control @error('price') is-invalid @enderror" id="price"
                                        aria-describedby="" placeholder="Enter Price">
                                    @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-8 text-center mb-1 mx-auto">
                                    <button type="submit" class="btn btn-block mybtn btn-success tx-tfm"
                                        onclick="return confirm('Are you sure you want to save this data?')">Add
                                        Petrol</button>

                                </div>

                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    function captureSelectedStation() {
        // Get the selected value from the dropdown
        var selectedStation = $('#stationName').val();

        console.log('Selected Station: ' + selectedStation);

    
    }
</script>
@endsection

@endsection