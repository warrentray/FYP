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
                            <th>Station Name</th>
                            <th>Amount</th>
                            <th>Image</th>
                            <th>Reason</th>
                            <th>Action</th>

                        </tr>
                    </thead>

                    @foreach($medicalClaims as $claim)
                    @if($claim->claim_status=='Pending' )
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $claim->user->name }}</td>
                        <td>{{ $claim->user->station->name }}</td>
                        <td>{{ $claim->amount }}</td>
                        <td>
                            <img src="{{ asset('admin/img/' . $claim->image) }}" alt="Medical Slip"
                                class="img-thumbnail">
                        </td>
                        <td>{{ $claim->reason }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('medicalClaim.approve', ['id' => $claim->id]) }}"
                                    class="btn btn-success">Approve</a>
                            </div>
                            <div class="btn-group mt-3">
                                <a href="{{ route('medicalClaim.reject', ['id' => $claim->id]) }}"
                                    class="btn btn-danger">Reject</a>
                            </div>
                        </td>
                    </tr>
                    @endif
                    @endforeach

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