<title>Edit Stock</title>
@extends('layouts.master')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js">
</script>
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">
@section('content')

@include('sweetalert::alert')

<div class="container-fluid text-dark ">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold  " style="font-size:20px; color:black;"><b>Edit Stock</b>
            </h6>
        </div>
        <div class=" card-body">
            <div class="row mt-6 ">
                <div class="row mt-2 ml-2 mb-4">
                    <a href="{{ route('viewStock') }}">
                        <button class="btn btn-warning btn-circle btn-xl"
                            style="width: 50px; height: 50px; border-radius: 35px; padding: 6px 0px;">
                            <span><i class="fa fa-arrow-left"></i></span>
                        </button>
                    </a>
                </div>
            </div>
            <div class="col-md-12 text-center  ">
                <h2><b>Station: Danau Kota</b></h2>
            </div>

            <form class="blockquote">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="deliveryNumber">Delivery Number:</label>
                        <input type="text" class="form-control" id="deliveryNumber" placeholder="Enter delivery number">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="tankNumber">Tank number:</label>
                        <select id="inputState" class="form-control">
                            <option selected>Choose stock in tank number</option>
                            <option>Tank 1</option>
                            <option>Tank 2</option>
                            <option>Tank 3</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="tankType">Tank Type:</label>
                        <input type="text" class="form-control" id="deliveryNumber" placeholder="Enter tank type">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="tankNumber">Tank number:</label>
                        <select id="inputState" class="form-control">
                            <option selected>Choose...</option>
                            <option>...</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="deliveryNumber">Time:</label>
                        <div class="cs-form">
                            <input type="time" class="form-control" value="10:05 AM" />
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="tankNumber">Date:</label>
                        <div class='input-group date' id='picker'>
                            <input placeholder="Select date" type="date" id="example" class="form-control">

                        </div>
                    </div>
                </div>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-2">
                    <button type="submit" class="  btn-warning data-bs-toggle=" button" autocomplete="off" ">Update</button>
        </div>
    </div>    
 
    </form>
    <script type=" text/javascript">
                        $(function () {
                        $('#picker').datetimepicker();
                        });
                        </script>
                        @endsection