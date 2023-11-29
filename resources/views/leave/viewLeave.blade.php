<title>Leave Management</title>

<!--@if(!session('user')){
return redirect('../login')->with('error', 'Please login to do the further action.');
}else if(session('user') && session('user')->role!='Manager'){
return redirect('../login')->with('error', 'Illegitimate Access!');
}
@endif-->
@extends('layouts.master')

@section('content')
<link href="{{asset('admin/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
@include('sweetalert::alert')

<div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold  " style="font-size:20px; color:black;"><b>Pending Leaves For Approval</b>
            </h6>
        </div>
        <div class=" card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Staff Name</th>
                            <th>Leave type</th>
                            <th>Leave period</th>
                            <th>Total days </th>
                            <th>Reason </th>
                            <th>Station Name </th>
                            <th>Action</th>

                        </tr>
                    </thead>

                    <tbody>
                        @foreach($staff_leave as $staffLeave)
                        @if($staffLeave->status=='Pending' )
                        <tr>

                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $staffLeave->user->name }}</td>
                            <td>{{ $staffLeave->leaveType }}</td>
                            <td>{{ $staffLeave->applyStartDate }} - {{ $staffLeave->applyEndDate}}</td>
                            <td>{{ $staffLeave->totalLeave }}</td>
                            <td>{{ $staffLeave->reason }}</td>
                            <td>{{ $staffLeave->user->station->name }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('leave.approve', ['leave_id' => $staffLeave->leave_id]) }}"
                                        class="btn btn-success">Approve</a>
                                </div>
                                <div class="btn-group">
                                    <a href="{{ route('leave.reject', ['leave_id' => $staffLeave->leave_id]) }}"
                                        class="btn btn-danger">Reject</a>
                                </div>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Page level plugins -->

@endsection