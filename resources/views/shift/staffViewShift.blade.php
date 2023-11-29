<title>Shift Management</title>

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

<div class="container-fluid">


    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold  " style="font-size:20px; color:black;"><b>Shift Management</b>
            </h6>
        </div>
        <div class=" card-body">

            <div class="text-left mb-4">
                <a href="{{ route('editShift') }}"><button class="btn btn-warning  ">Reschedule shift</button></a>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Staff Name</th>
                            <th>Leave Period</th>
                            <th>Status</th>
                            <th>Shift Mode</th>

                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Tan ah wei</td>
                            <td>1-10 october</td>
                            <td>Offday</td>
                            <td>Afternoon applyShift</td>


                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Tan ah wei</td>
                            <td>1-10 october</td>
                            <td>Offday</td>
                            <td>Afternoon applyShift</td>
                        </tr>

                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
@endsection