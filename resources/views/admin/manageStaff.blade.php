<title>Staff Management</title>

@extends('layouts.master')

@section('content')
<link href="{{ asset('admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@include('sweetalert::alert')
<div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold" style="font-size:20px; color:black;"><b>Staff Management</b></h6>
        </div>
        <div class=" card-body">
            <div class="text-left mb-4">
                <a href="{{ route('addStaff') }}">
                    <button class="btn btn-warning">Create new staff</button>
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Staff ID</th>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Station Name</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $s)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $s->id }}</td>
                            <td>{{ $s->name }}</td>
                            <td>{{ $s->role }}</td>
                            <td>{{ $s->station->name }}</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button"
                                        class="btn dropdown-toggle
                                    @if($s->status === 'Normal') btn-success @elseif($s->status === 'Resign') btn-danger @endif"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{ $s->status }}
                                    </button>

                                    <div class="dropdown-menu">
                                        <form action="{{ route('changeStatus') }}" method="post">
                                            @csrf

                                            <input type="hidden" name="id" value="{{ $s->id }}">
                                            <button type="submit" class="dropdown-item" name="new_status"
                                                value="Normal">Normal</button>
                                            <button type="submit" class="dropdown-item" name="new_status"
                                                value="Resign">Resign</button>
                                        </form>

                                    </div>
                                    <form action="{{ route('salary', ['id' => $s->id]) }}" method="GET">
                                        @csrf
                                        @method('put')

                                        <button type="submit" class="btn btn-primary ml-4"
                                            name=" Generatepayslip">Generate
                                            payslip</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection