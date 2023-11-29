<title>Edit Petrol Information</title>
@extends('layouts.master')

@section('content')
@include('sweetalert::alert')

<div class="container text-dark ">
    <!-- Edit Your Personal Setting -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold  " style="font-size:20px; color:black;"><b>Edit petrol information</b>
            </h6>
        </div>
        <div class="card-body">
            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            <div class="row mt-4 ">
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
                            <form method="POST" action="{{ route('editPetrol', ['id' => $petrols->id]) }}">
                                @csrf
                                @method('put')
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Fuel Name</label>
                                    <input type="text" name="fuelname"
                                        class="form-control @error('fuelname') is-invalid @enderror" id="fuelname"
                                        aria-describedby="" value={{$petrols->petrol_name}}>
                                    @error('fuelname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputGender">Petrol type</label>
                                    <select class="form-control" name="petrol" @error('petrol') is-invalid @enderror"
                                        id="petrol">
                                        <option value="Petrol" {{ $petrols->petrol_type === 'Petrol' ? 'selected' :
                                            ''
                                            }}>Petrol</option>
                                        <option value="Diesel" {{ $petrols->petrol_type === 'Diesel' ? 'selected' :
                                            ''
                                            }}>Diesel</option>
                                    </select>
                                    @error('petrol')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Price (RM):</label>
                                    <input type="text" name="price"
                                        class="form-control @error('price') is-invalid @enderror" id="price"
                                        aria-describedby="" value={{$petrols->price_per_liter}}>
                                    @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="col-md-8 text-center mb-1 mx-auto">
                                    <button type="submit" class=" btn btn-block mybtn btn-success  tx-tfm">Update
                                        Petrol</button>


                                </div>


                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection