<title>Leave History </title>

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
            <div class="row mt-6 ">
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
                            <th>Date From</th>
                            <th>Date To</th>
                            <th>Total days </th>
                            <th>Status</th>
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
                                    <a href="{{ route('editLeave') }}">
                                        <button type="button" class="btn btn-warning">Edit</button>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-danger">Delete</button>
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
                                    <button type="button" class="btn btn-warning">Edit</button>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-danger">Delete</button>
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
                                    <button type="button" class="btn btn-warning">Edit</button>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-danger">Delete</button>
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