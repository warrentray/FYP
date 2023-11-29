<!--@if(!session('user')){
return redirect('../login')->with('error', 'Please login to do the further action.');
}else if(session('user') && session('user')->role!='Manager'){
return redirect('../login')->with('error', 'Illegitimate Access!');
}
@endif-->
<title>Dashboard Payslip</title>
@include('sweetalert::alert')

@extends('layouts.master')

@section('content')
<link href="{{asset('admin/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold  " style="font-size:20px; color:black;"><b>Payslip Management</b>
            </h6>
        </div>
        <div class=" card-body">
            <div class="form-group mt-2 mb-4 row">
                <label for="staticEmail" class="col-sm-2 col-form-la
                bel "><b>Station Name: </b></label>
                <div class="col-sm-4">
                    <select class="form-control ">
                        <option>Choose station</option>
                    </select>
                </div>
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
                        <tr>
                            <td>1</td>
                            <td>S001</td>
                            <td>Staff</td>
                            <td>Edinburgh</td>
                            <td>Danau</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('generatePayslip') }}">
                                        <button type="button" class="btn btn-warning ">Uplaod Payslip</button>
                                </div>

                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>S002</td>
                            <td>Staff</td>
                            <td>Jacl</td>
                            <td>Stapak</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('generatePayslip') }}">
                                        <button type="button" class="btn btn-warning ">Uplaod Payslip</button>
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