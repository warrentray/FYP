<title>Stock in </title>
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
            <h6 class="m-0 font-weight-bold  " style="font-size:20px; color:black;"><b>Stockin Management</b>
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
                        <?php $i = 1; ?>
                        <tr>
                            <th>No </th>
                            <th>Tank number</th>
                            <th>Petrol type</th>
                            <th>Currently stock quantity</th>
                            <th>Stock in quantity</th>
                        </tr>

                    </thead>

                    <tbody>
                        @foreach ($delivery as $delivery)
                        @if($delivery->status === 'Delivered' && !session()->has('updatedDeliveries.' . $delivery->id))
                        <tr>
                            <td> {{$i++}}</td>
                            <td>Tank {{$delivery->tank_number}}</td>
                            <td>{{$delivery->petrol_type}} </td>
                            <td>{{$delivery->stock->tank_quantity}} (L)</td>
                            <td>
                                <form action="{{ route('updateStock', ['id' => $delivery->stock->id]) }}" method="post">
                                    @csrf
                                    @method('put')
                                    <div class="input-group">
                                        <input type="number" name="stockin" class="form-control" id="stockin"
                                            aria-describedby="" placeholder="Enter stock quantity" required>
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-success">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </td>
                        </tr>

                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


@endsection