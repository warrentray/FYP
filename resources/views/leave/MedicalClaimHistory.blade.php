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
<style>
    .zoomable-image {
        max-height: 300px;
        cursor: pointer;
        transition: transform 0.3s ease;
    }

    .zoomable-image:hover {
        transform: scale(1.2);
        /* Increase the scale on hover for zoom effect */
    }

    .modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0, 0, 0);
        background-color: rgba(0, 0, 0, 0.9);
        padding-top: 60px;
    }

    .modal-content {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
    }

    #caption {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
        text-align: center;
        color: #ccc;
        padding: 10px 0;
        height: 150px;
    }
</style>
<div class="container-fluid">

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold  " style="font-size:20px; color:black;"><b>Medical Claim History </b>
            </h6>
        </div>
        <div class=" card-body">
            <div class="row mt-6">
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
                            <th>Image</th>
                            <th>Amount (RM)</th>
                            <th>Reason</th>
                            <th>Claim Date </th>
                            <th>Status</th>
                            <th>Action</th>

                        </tr>
                    </thead>

                    @foreach($medicalClaim as $claim)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <a href="#" onclick="openModal('{{ asset('admin/img/' . $claim->image) }}')">
                                <img src="{{ asset('admin/img/' . $claim->image) }}" alt="Medical Slip"
                                    class="img-thumbnail zoomable-image">
                            </a>
                        </td>
                        <td>{{ $claim->amount}}</td>
                        <td>{{ $claim->reason }}</td>
                        <td>{{ $claim->created_at}}</td>
                        <td>{{ $claim->claim_status}}</td>
                        <td> @if($claim->claim_status==='Pending')
                            <button type="button" class="btn btn-warning">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-pen" viewBox="0 0 16 16">
                                    <path
                                        d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z">
                                    </path>
                                </svg>
                                Edit
                            </button>
                        </td>
                        @endif
                    </tr>
                    @endforeach

                </table>
            </div>
        </div>
    </div>
    <div id="myModal" class="modal" onclick="closeModal()">
        <span class="close"
            style="position: absolute; top: 15px; right: 15px; color: white; font-size: 30px;">&times;</span>
        <div class="modal-content">
            <img id="img01" style="width: 100%;">
            <div id="caption"></div>
        </div>
    </div>
</div>
<script>
    function openModal(imageSrc) {
        var modal = document.getElementById('myModal');
        var modalImg = document.getElementById("img01");
        var captionText = document.getElementById("caption");

        modal.style.display = "block";
        modalImg.src = imageSrc;
        captionText.innerHTML = "Click outside the image to close the modal";
    }

    function closeModal() {
        var modal = document.getElementById('myModal');
        modal.style.display = "none";
    }
</script>

@endsection