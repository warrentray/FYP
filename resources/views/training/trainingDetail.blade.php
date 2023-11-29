<!-- trainingDetail.blade.php -->

@extends('layouts.master')
@include('sweetalert::alert')

@section('content')
<link href="{{asset('admin/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">

<div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold" style="font-size:20px; color:black;"><b>Training Detail</b></h6>
        </div>
        <div class="card-body">
            <!-- Your back button code -->

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Training Name</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Description</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>{{ $training->training_name }}</td>
                            <td>{{ $training->start_date }}</td>
                            <td>{{ $training->end_date }}</td>
                            <td>{{ $training->description }}</td>
                            <td>{{ $training->status }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
@endsection