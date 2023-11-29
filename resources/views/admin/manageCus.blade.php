<!--@if(!session('user')){
return redirect('../login')->with('error', 'Please login to do the further action.');
}else if(session('user') && session('user')->role!='Manager'){
return redirect('../login')->with('error', 'Illegitimate Access!');
}
@endif-->
<title>Dashboard Customer</title>

@extends('layouts.master')

@section('content')
<link href="{{asset('admin/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">

<div class="container-fluid">
    @include('sweetalert::alert')
 
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold  " style="font-size:20px; color:black;"><b>Customer Management</b>
            </h6>
        </div>
        <div class=" card-body">

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Email Address</th>
                            <th>Referral Code</th>
                            <th>Membership Rank</th>
                            <th>Membership Point</th>
                            <th>Membership Card</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $i = 1; ?>

                        @foreach ($customers as $customer)
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{ $customer->name }}</td>
                            <td>{{ $customer->email }}</td>
                            <td>{{ $customer->referral_code }}</td>
                            <td>{{ $customer->cust_rank }}</td>
                            <td>{{ $customer->cust_points }}</td>
                            <td>{{ $customer->membershipCard }}</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button"
                                        class="btn dropdown-toggle
                                    @if($customer->status === 'Active') btn-success @elseif($customer->status === 'Block') btn-danger @endif"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{ $customer->status }}
                                    </button>

                                    <div class="dropdown-menu">
                                        <form action="{{ route('changeCustomerStatus') }}" method="post">
                                            @csrf

                                            <input type="hidden" name="id" value="{{ $customer->id }}">
                                            <button type="submit" class="dropdown-item" name="new_status"
                                                value="Active">Active</button>
                                            <button type="submit" class="dropdown-item" name="new_status"
                                                value="Block">Block</button>
                                        </form>

                                    </div>
                                </div>
                            </td>

                        </tr>
                        @endforeach


                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
</div>

@endsection