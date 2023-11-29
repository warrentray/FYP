<title>Stock Management</title>
<!--@if(!session('user')){
return redirect('../login')->with('error', 'Please login to do the further action.');
}else if(session('user') && session('user')->role!='Manager'){
return redirect('../login')->with('error', 'Illegitimate Access!');
}
@endif-->
@extends('layouts.master')

@section('content')
@include('sweetalert::alert')

<link href="{{asset('admin/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<style>
    .btn-primary,
    .btn-primary:active,
    .btn-primary:visited {
        background-color: #6046FF !important;
    }

    .btn-second,
    .btn-second:active,
    .btn-second:visited {
        background-color: #6930c3;
        color: white;

    }



    .btn-second:hover {
        background-color: #9f86c0 !important;
        transition: all 1s ease;
        -webkit-transition: all 1s ease;
        -moz-transition: all 1s ease;
        -o-transition: all 1s ease;
        -ms-transition: all 1s ease;
        color: white;
    }





    .btn-primary:hover {
        background-color: #7d6af8 !important;
        transition: all 1s ease;
        -webkit-transition: all 1s ease;
        -moz-transition: all 1s ease;
        -o-transition: all 1s ease;
        -ms-transition: all 1s ease;
    }
</style>
<div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold  " style="font-size:20px; color:black;"><b>Delivery Management</b>
            </h6>
        </div>
        <div class=" card-body">
            <div class="row mt-2 mb-4">
                <div>
                    <a href="{{ route('manageStaff') }}">
                        <button class="btn btn-warning btn-circle btn-xl"
                            style="width: 50px; height: 50px; border-radius: 35px; padding: 6px 0px;">
                            <span><i class="fa fa-arrow-left"></i></span>
                        </button>
                    </a>
                </div>
            </div>

            <form method="get" action="{{ route('requestStock') }}">
                @csrf
                <div class="form-group row">

                    <label for="exampleInputGender" class="col-sm-2 col-form-label">
                        <h3><b>Station:</b></h3>
                    </label>
                    <div class="row mb-4">
                        <div class="col ">
                            <select class="form-control" name="stationName" id="stationName" onchange="updateStation()">
                                @foreach ($stations as $station)
                                <option value="{{ $station->name }}">{{ $station->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="text-left mb-4">
                    <button type="submit" class="btn btn-primary">Add Stock</button>
                    <a href="{{ route('editStock') }}" class="btn btn-second">Edit Stock</a>
                </div>
            </form>


            <div class=" table-responsive">
                @if($deliverys->isEmpty())
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Delivery ID</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                @else
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Delivery ID</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $i = 1; ?>

                        @php
                        $previousStation = null;
                        $previousDate = null;
                        $previousTime = null;
                        @endphp




                        @php
                        $statusColor = '';
                        @endphp

                        @php
                        $statusColor = '';
                        @endphp
                        @foreach ($deliverys as $delivery)
                        @php
                        $statusColor = '';

                        if ($delivery->status === 'Delivered') {
                        $statusColor = 'green';
                        } elseif ($delivery->status === 'On Road') {
                        $statusColor = 'blue';
                        } elseif ($delivery->status === 'Pending') {
                        $statusColor = 'orange';
                        }
                        @endphp

                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $delivery->id }}</td>
                            <td>{{ $delivery->date }}</td>
                            <td>{{ $delivery->time }}</td>
                            <td style="color: {{ $statusColor }}">
                                {{ $delivery->status }}
                            </td>
                            <td>
                                <a href="{{ route('infoStock', ['deliveryId' => $delivery->id]) }}">
                                    <button type="button" class="btn btn-warning">View Detail</button>
                                </a>
                            </td>
                        </tr>
                        @endforeach

                        </tr>
                        {{-- @endif --}}
                        @php
                        $previousStation = $delivery->station_id;
                        $previousDate = $delivery->date;
                        $previousTime = $delivery->time;
                        @endphp


                    </tbody>
                </table>
                @endif

            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>

<script>
    document.getElementById('addStockButton').addEventListener('click', function() {
        const selectedStation = document.getElementById('stationName').value;
        const addStockURL = "{{ route('requestStock') }}?stationName=" + selectedStation;
        window.location.href = addStockURL;
    });
</script>
@endsection