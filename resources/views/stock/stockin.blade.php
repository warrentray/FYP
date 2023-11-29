<title>Add Stock</title>
@extends('layouts.master')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js">
</script>
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">
@include('sweetalert::alert')

@section('content')
<div class="container-fluid text-dark">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold" style="font-size:20px; color:black;"><b>Stock Details</b></h6>
        </div>
        <div class="card-body">
            <div class="row mt-2 ml-2 mb-4">
                <a href="{{ route('viewStock') }}">
                    <button class="btn btn-warning btn-circle btn-xl"
                        style="width: 50px; height: 50px; border-radius: 35px; padding: 6px 0px;">
                        <span><i class="fa fa-arrow-left"></i></span>
                    </button>
                </a>
            </div>
            <div class="col-md-12 text-center">
                <h2><b>Station: Danau Kota</b></h2>
            </div>

            <div class="blockquote">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="deliveryNumber">Delivery Number:</label>
                        @if ($delivery)
                        <input type="text" class="form-control" id="deliveryNumber" value="{{ $delivery->id }}"
                            readonly>
                        @endif

                    </div>
                    <div class="form-group col-md-6">
                        <label for="tankNumber">Tank number:</label>
                        @if ($delivery)
                        <input type="text" class="form-control" id="tankNumber" value="{{ $delivery->tank_number }}"
                            readonly>
                        @endif
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="tankType">Tank Type:</label>
                        @if ($delivery)
                        <input type="text" class="form-control" id="tankType" value="{{ $delivery->tank_type }}"
                            readonly>
                        @endif
                    </div>
                    <div class="form-group col-md-6">
                        <label for="tankQuantity">Tank Quantity:</label>
                        @if ($delivery)
                        <input type="text" class="form-control" id="tankQuantity" value="{{ $delivery->tank_quantity }}"
                            readonly>
                        @endif
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="deliveryTime">Time:</label>
                        @if ($delivery)
                        <input type="text" class="form-control" id="deliveryTime" value="{{ $delivery->delivery_time }}"
                            readonly>
                        @endif
                    </div>

                    <div class="form-group col-md-6">
                        <label for="deliveryDate">Date:</label>
                        @if ($delivery)
                        <input type="text" class="form-control" id="deliveryDate" value="{{ $delivery->delivery_date }}"
                            readonly>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection