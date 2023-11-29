<title>Shift Management</title>

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
            <h6 class="m-0 font-weight-bold  " style="font-size:20px; color:black;"><b>Approve & Reject Shift </b>
            </h6>
        </div>
        <div class=" card-body">

            <div class="text-left mb-4">
                <a href="{{ route('applyShift') }}"><button class=" btn btn-primary ">Reschedule shift</button></a>

            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Staff Name</th>
                            <th>Shift type</th>
                            <th>Station Name</th>
                            <th>Reason</th>
                            <th>Action</th>

                        </tr>
                    </thead>

                    <tbody>
                        @foreach($users as $s)
                        @if($s->shift->ShiftChangeStatus=='Pending' )
                        <tr>

                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $s->name }}</td>
                            <td>{{ $s->shift->ShiftType }}</td>
                            <td>{{ $s->station->name }}</td>
                            <td>{{ $s->shift->Reason }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('shift.approve', ['id' => $s->shift->id]) }}"
                                        class="btn btn-success">Approve</a>
                                </div>
                                <div class="btn-group">
                                    <a href="{{ route('shift.reject', ['id' => $s->shift->id]) }}"
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