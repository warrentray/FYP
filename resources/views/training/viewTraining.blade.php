<title>Training Management</title>

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
    @include('sweetalert::alert')

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold  " style="font-size:20px; color:black;"><b>Training Management</b>
            </h6>
        </div>
        <div class=" card-body">

            <div class="text-left mb-4">
                <a href="{{ route('trainings.create') }}"><button class="btn btn-warning  ">Add
                        training</button></a>
            </div>


            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Training Id</th>
                            <th>Training Name</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status </th>
                            <th>Information</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($trainings as $training)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $training->id }}</td>
                            <td>{{ $training->training_name }}</td>
                            <td>{{ $training->start_date }}</td>
                            <td>{{ $training->end_date }}</td>
                            <td>{{ $training->status }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('trainings.show', $training->id) }}" class="btn btn-success">View
                                        detail</a>
                                </div>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('trainings.edit', $training->id) }}"
                                        class="btn btn-warning">Edit</a>
                                </div>
                                <div class="btn-group">
                                    <form action="{{ route('trainings.destroy', $training->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8">No training records found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- End of Main Content -->

<!-- Page level plugins -->

@endsection