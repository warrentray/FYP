<title>Payslip Management</title>

<!--@if(!session('user')){
return redirect('../login')->with('error', 'Please login to do the further action.');
}else if(session('user') && session('user')->role!='Manager'){
return redirect('../login')->with('error', 'Illegitimate Access!');
}
@endif-->

@extends('layouts.master')

@section('content')
<style>
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
</style>
<link href="{{asset('admin/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">

<div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold  " style="font-size:20px; color:black;"><b>Payslip History</b>
            </h6>
        </div>
        <div class=" card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Date</th>
                            <th class="text-center">Action</th>

                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>BACK to hometown </td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-success ">View Detail</button>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-danger">Delete</button>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-second">Download</button>
                                </div>
                            </td>
                        </tr>
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