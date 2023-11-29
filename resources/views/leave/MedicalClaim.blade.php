<!--@if(!session('user')){
return redirect('../login')->with('error', 'Please login to do the further action.');
}else if(session('user') && session('user')->role!='Manager'){
return redirect('../login')->with('error', 'Illegitimate Access!');
}
@endif-->
@extends('layouts.master')
@include('sweetalert::alert')

@section('content')
<title>Medical Claim</title>

<link href="{{asset('admin/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
@if($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold  " style="font-size:20px; color:black;"><b>Medical Claim</b>
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
            <form method="POST" action="{{ route('uploadMedical') }}" enctype="multipart/form-data">

                @csrf
                <div class="form-group ml-2 mb-6 row">
                    <label for="medicalSlip" class="col-sm-3 col-form-label">Choose file upload medical slip: </label>
                    <div class="col-sm-9">

                        <input class="form-control col-sm-6 " accept="image/*" type="file" name="medicalSlip"
                            id="medicalSlip" multiple>
                        @error('medicalSlip')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group ml-2 mb-6 row">
                    <label for="amount" class="col-sm-3 col-form-label">Amount (RM): </label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control col-sm-6" id="amount" name="amount" min="0">
                        @error('amount')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group ml-2 mb-6 row">
                    <label for=" claimReason" class="col-sm-3 col-form-label">Claim Reason:</label>
                    <div class="col-sm-9">
                        <textarea class=" form-control" name="claimReason" id="claimReason" rows="5"
                            placeholder="Enter claim reason"></textarea>
                        @error('claimReason')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-2">
                    <button type="submit" class="  btn-warning data-bs-toggle=" button" autocomplete="off" ">Claim Now</button>
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