<title>Payslip Calculation</title>
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
            <h6 class="m-0 font-weight-bold  " style="font-size:20px; color:black;"><b>Payslip Calculation</b>
            </h6>
        </div>
        <div class="card shadow mb-4">
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

                <form class="blockquote" action="#" name="registration">
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Station Name: </label>
                        <div class="form-group col-md-3">
                            <select id="inputState" class="form-control">
                                <option selected>Choose Station name </option>
                                <option>Jack</option>
                            </select>
                        </div>

                    </div>
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Staff Name: </label>
                        <div class="form-group col-md-3">
                            <select id="inputState" class="form-control">
                                <option selected>Choose staff name </option>
                                <option>Jack</option>
                            </select>
                        </div>
                        <label for="staticEmail" class="col-sm-3 col-form-label">Basic Salary (RM): </label>
                        <div class="form-group col-md-3">
                            <input type="text" name="fullname" class="form-control" id="fullname" aria-describedby=" "
                                placeholder=" XXXX.XX">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Bonus Type: </label>
                        <div class="form-group col-md-3">
                            <select id="inputState" class="form-control">
                                <option selected>Choose bonus type </option>
                                <option>Jack</option>
                            </select>
                        </div>
                        <label for="staticEmail" class="col-sm-3 col-form-label">Bonus Amount (RM): </label>
                        <div class="form-group col-md-3">
                            <input type="text" name="fullname" class="form-control" id="fullname" aria-describedby=" "
                                placeholder=" XXXX.XX">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">EPF (RM): </label>
                        <div class="form-group col-md-3">
                            <input type="text" name="fullname" class="form-control" id="fullname" aria-describedby=" "
                                placeholder=" XXXX.XX">
                        </div>

                        <label for="staticEmail" class="col-sm-3 col-form-label">SOCSO (RM): </label>
                        <div class="form-group col-md-3">
                            <input type="text" name="fullname" class="form-control" id="fullname" aria-describedby=" "
                                placeholder=" XXXX.XX">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">EIS (RM): </label>
                        <div class="form-group col-md-3">
                            <input type="text" name="fullname" class="form-control" id="fullname" aria-describedby=" "
                                placeholder=" XXXX.XX">
                        </div>

                        <label for="staticEmail" class="col-sm-3 col-form-label">Medical Claim (RM): </label>
                        <div class="form-group col-md-3">
                            <input type="text" name="fullname" class="form-control" id="fullname" aria-describedby=" "
                                placeholder=" XXXX.XX">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Leave Amount (RM): </label>
                        <div class="form-group col-md-3">
                            <input type="text" name="fullname" class="form-control" id="fullname" aria-describedby=" "
                                placeholder=" XXXX.XX">
                        </div>
                        <label for="staticEmail" class="col-sm-3 col-form-label">Net Pay Amount (RM): </label>
                        <div class="form-group col-md-3">
                            <input type="text" name="fullname" class="form-control" id="fullname" aria-describedby=" "
                                placeholder=" XXXX.XX">
                        </div>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-2">
                        <button type="submit" class="  btn-warning data-bs-toggle=" button" autocomplete="off" ">Apply</button>
            </div>   
        </form> 
    </div>
    </div> 
</div>  
    <script type=" text/javascript">
                            $(function () {
                            $('#picker').datetimepicker();
                            });
                            </script>
                            @endsection