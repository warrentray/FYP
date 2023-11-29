<title>Petrol Management</title>
<!--@if(!session('user')){
return redirect('../login')->with('error', 'Please login to do the further action.');
}else if(session('user') && session('user')->role!='Manager'){
return redirect('../login')->with('error', 'Illegitimate Access!');
}
@endif-->
@extends('layouts.master')

@section('content')
<link href="{{asset('admin/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>

@include('sweetalert::alert')
<div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold  " style="font-size:20px; color:black;"><b>Petrol Management</b>
            </h6>
        </div>
        <div class=" card-body">
            <div class="text-left mb-4">
                <a href="{{ route('addPetrol') }}"><button class="btn btn-warning  ">Add petrol</button></a>
                {{-- <a href="{{ route('editPetrol') }}"><button class=" btn btn-primary ">Edit petrol</button></a> --}}
            </div>

            <div class=" table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Fuel Name</th>
                            <th>Fuel Type</th>
                            <th>Price (RM)</th>
                            <th>Station Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $i = 1; ?>
                        @foreach ($station as $station)
                        @foreach ($petrols as $petrol)
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{ $petrol->petrol_name }}</td>
                            <td>{{ $petrol->petrol_type }}</td>
                            <td>{{ $petrol->price_per_liter }}</td>
                            <td>{{ $station->name }}</td>
                            <td>
                                <div style="display: inline-block">
                                    <form action="{{ route('editPetrol', $petrol->id)}}" method="GET">
                                        @csrf
                                        @method('put')

                                        <button class="btn btn-primary" type="submit">Edit</button>

                                    </form>
                                </div>
                                <div style="display: inline-block">
                                    <form id="deletepetrol{{ $petrol->id }}"
                                        action="{{ url('deletepetrol/' . $petrol->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger confirm-button"
                                            data-form-id="deletepetrol{{ $petrol->id }}" type="button">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const confirmButtons = document.querySelectorAll('.confirm-button');

        confirmButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                const formId = button.getAttribute('data-form-id');
                const deleteForm = document.getElementById(formId);

                swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                }).then((willCancel) => {
                    if (willCancel) {
                        deleteForm.submit(); // Submit the form
                    }
                });
            });
        });
    });
</script>

@endsection