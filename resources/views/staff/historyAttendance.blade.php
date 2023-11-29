<!-- resources/views/staff/historyAttendance.blade.php -->

<title>Attendance</title>
@extends('layouts.master')
<script src="https://cdn.jsdelivr.net/npm/instascan@1.0.0"></script>
<script src="https://unpkg.com/html5-qrcode"></script>
<!-- Include Chart.js library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@section('content')
@include('sweetalert::alert')


<link href="{{asset('admin/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">

<div class="container-fluid">

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold" style="font-size:20px; color:black;"><b>Histroy Attendance</b></h6>
        </div>
        <div class="card-body">
            <div class="row mt-2 ml-2 MB-3">
                <a href="{{ route('dailyattendance') }}">
                    <button class="btn btn-warning btn-circle btn-xl"
                        style="width: 50px; height: 50px; border-radius: 35px; padding: 6px 0px;">
                        <span><i class="fa fa-arrow-left"></i></span>
                    </button>
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Working date:</th>
                            <th>Sign in</th>
                            <th>Sign out</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($user->reverse() as $user)

                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{ \Carbon\Carbon::parse($user->sign_in_time)->toDateString() }}</td>
                            <td>{{ \Carbon\Carbon::parse($user->sign_out_time)->toTimeString() }}</td>
                            <td>{{ \Carbon\Carbon::parse($user->end_date)->toTimeString() }}</td>

                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
@endsection