<title>Shift Management</title>

<!--@if(!session('user')){
return redirect('../login')->with('error', 'Please login to do the further action.');
}else if(session('user') && session('user')->role!='Manager'){
return redirect('../login')->with('error', 'Illegitimate Access!');
}
@endif-->
@extends('layouts.master')
@include('sweetalert::alert')

@section('content')
<link href="{{asset('admin/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">

<div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold  " style="font-size:20px; color:black;"><b>Pending Leaves For Approval</b>
            </h6>
        </div>
        <div class=" card-body">
            <div class="dropdown show mb-4">
                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Danau Station
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="#">KL Station</a>
                    <a class="dropdown-item" href="#">Segamat Station</a>
                    <a class="dropdown-item" href="#">Setapak Station</a>
                </div>
            </div>
            <div class="form-group row">
                <label for="staticEmail" class="col-sm-3 col-form-label">Attendance: </label>
                <div class="form-group col-md-3">
                    <select id="inputState" class="form-control">
                        <option selected>Choose Attendance </option>

                    </select>
                </div>

            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Staff Name</th>
                            <th>Leave type</th>
                            <th>Leave period</th>
                            <th>Total days </th>
                            <th>Station Name </th>
                            <th>Action</th>

                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Edinburgh</td>
                            <td>Morning</td>
                            <td>SEGAMAT</td>
                            <td>BACK to hometown </td>
                            <td>BACK to hometown </td>

                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-success">Approve</button>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-danger">Reject</button>
                                </div>
                            </td>

                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Jacl</td>
                            <td>Morning</td>
                            <td>Jacl</td>
                            <td>sadasd</td>
                            <td>BACK to hometown </td>

                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-success">Approve</button>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-danger">Reject</button>
                                </div>
                            </td>

                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Jacl</td>
                            <td>Afternoon</td>
                            <td>Guo Xing</td>
                            <td>SL003</td>
                            <td>BACK to hometown </td>

                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-success">Approve</button>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-danger">Reject</button>
                                </div>
                            </td>

                        </tr>
                        <tr>
                            <td>4</td>
                            <td>S004</td>
                            <td>Afternoon</td>
                            <td>Qi Guo</td>
                            <td>SL004</td>
                            <td>BACK to hometown </td>

                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-success">Approve</button>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-danger">Reject</button>
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