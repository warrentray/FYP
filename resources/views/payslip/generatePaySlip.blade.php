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

<div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold  " style="font-size:20px; color:black;"><b>Upload payslip</b>
            </h6>
        </div>
        <div class=" card-body">
            <div class="row mt-6 ">
                <div class="row mt-2 ml-2 mb-4">
                    <a href="{{ route('AdminDashboardPayslip') }}">
                        <button class="btn btn-warning btn-circle btn-xl"
                            style="width: 50px; height: 50px; border-radius: 35px; padding: 6px 0px;">
                            <span><i class="fa fa-arrow-left"></i></span>
                        </button>
                    </a>
                </div>
            </div>
            <form>
                <div class="form-group col-md-6">

                    <div class="dropdown mt-3">
                        <label for="exampleInputGender">Staff Name : Jack</label>

                    </div>
                    <div class="dropdown mt-3">
                        <label for="exampleInputGender">Station Name : Danau</label>

                    </div>
                </div>
                <div class="form-group ml-0 mb-8 row">
                    <label for="staticEmail" class="col-sm-3 col-form-label">Choose file upload medical: </label>
                    <div class="col-sm-9">
                        <input class="form-control col-sm-4 " type="file" id="formFileMultiple" multiple>

                    </div>
                </div>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-2">
                    <button type="submit" class="  btn-warning data-bs-toggle=" button">Upload</button>
                </div>
            </form>

        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Page level plugins -->

@endsection