<title>Leave History </title>

{{--
<!-- @if(!session('user'))
    return redirect('../login')->with('error', 'Please login to do the further action.');
@elseif(session('user') && session('user')->role != 'Manager')
    return redirect('../login')->with('error', 'Illegitimate Access!');
@endif --> --}}

@extends('layouts.master')

@section('content')
<link href="{{ asset('admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

<div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold" style="font-size:20px; color:black;"><b>Leave History</b>
            </h6>
        </div>
        <div class=" card-body">
            <div class="row mt-6">
                <div class="row mt-2 ml-2 mb-4">
                    <a href="{{ route('dashApply') }}">
                        <button class="btn btn-warning btn-circle btn-xl"
                            style="width: 50px; height: 50px; border-radius: 35px; padding: 6px 0px;">
                            <span><i class="fa fa-arrow-left"></i></span>
                        </button>
                    </a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Leave type</th>
                            <th>Leave Date</th>
                            <th>Reason</th>
                            <th>Total days</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($staff_leave as $index => $staffLeave)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $staffLeave->leaveType }}</td>
                            <td>{{ $staffLeave->applyStartDate }} - {{ $staffLeave->applyEndDate }}</td>
                            <td>{{ $staffLeave->reason }}</td>
                            <td>{{ $staffLeave->totalLeave }}</td>
                            <td
                                style="color: @if($staffLeave->status == 'Pending') blue @elseif($staffLeave->status == 'Rejected') red @elseif($staffLeave->status == 'Approved') green @endif;">
                                {{ $staffLeave->status }}
                            </td>
                            <td> @if($staffLeave->status === 'Pending' && strtotime($staffLeave->applyStartDate) >=
                                strtotime(now()))

                                <a href="{{ route('editLeave', ['id' => $staffLeave->id]) }}"
                                    class="btn btn-warning">Edit</a>
                                    @else 
                                    
                                @endif
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