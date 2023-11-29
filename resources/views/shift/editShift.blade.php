<title>Edit Shift </title>
@extends('layouts.master')

@section('content')
@include('sweetalert::alert')

<div class="container text-dark ">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold  " style="font-size:20px; color:black;"><b>Edit Shift </b>
            </h6>
        </div>
        <div class="card-body">

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

                            <form action="#" name="registration">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Station Name</label>
                                    <input type="text" name="fullname" class="form-control" id="fullname"
                                        aria-describedby=" " placeholder="Setapak">
                                </div>

                                <div class="form-group">
                                    <div class="dropdown">
                                        <label for="exampleInputGender">Shift type</label>
                                        <select class="form-control ">
                                            <option>Choose shift</option>
                                            <option>Morning shift</option>
                                            <option>Afternoo1 shift</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Reason</label>
                                    <input type="text" name="Price" class="form-control" id="Price" aria-describedby=" "
                                        placeholder="WRITE YOUR REASON">
                                </div>
                                <div class="col-md-8 text-center mb-1 mx-auto">
                                    <button type="submit" class=" btn btn-block mybtn btn-success  tx-tfm">Update
                                        shift</button>
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