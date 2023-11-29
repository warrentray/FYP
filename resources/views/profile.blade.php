<title>Profile</title>
@extends('sidebar.customer')
@section('navbar')



<div class="container bg-white text-dark">
    <div class="row">
        <!-- Edit Your Personal Setting -->
        <div class="col-xxl-8 mb-5 mb-xxl-0">
            <div class="px-4 py-5 rounded">
                <div id="first" class="border p-4 text-dark">
                    <div class="row text-dark">
                        <div class="col-md-12 text-left">
                            <h2 class="mb-4 mt-0">Edit Your Personal Setting</h2>
                            <h6 class="text-dark">Please fill in all the information correctly</h6>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Name</label>
                            <h4 class="border p-1 mb-2"> {{ $customer['name'] }} </h4>

                        </div>



                        <div class="col-md-6">
                            <label class="form-label">Email Address *</label>
                            <h4 class="border p-1 mb-2">{{ $customer['email'] }} </h4>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Referral Code</label>
                            <h4 class="border p-1 mb-2">{{ $customer['referral_code'] }}
                            </h4>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="Rank" class="form-label">Membership Rank *</label>
                            <h4 class="border p-1 mb-2">{{ $customer['cust_rank'] }} </h4>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="Point" class="form-label">Membership Point</label>
                            <h4 class="border p-1 mb-2">{{ $customer['reward_points'] }}
                                Point</h4>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Membership Card</label>
                            <h4 class="border p-1 mb-2"> {{ $customer['membershipCard'] }} </h4>
                            <button class="mb-2" id="toggleQrCode">Show QR Code</button>

                            <!-- QR Code container initially hidden -->
                            <div id="qrCodeContainer" style="display: none;">
                                <h6>{!! QrCode::size(300)->generate($customer['membershipCard']) !!}</h6>
                            </div>
                        </div>
                    </div>

                </div> <!-- Row END -->
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('toggleQrCode').addEventListener('click', function() {
        var qrCodeContainer = document.getElementById('qrCodeContainer');
        if (qrCodeContainer.style.display === 'none') {
            qrCodeContainer.style.display = 'block';
            this.innerText = 'Hide QR Code';
        } else {
            qrCodeContainer.style.display = 'none';
            this.innerText = 'Show QR Code';
        }
    });
</script>
@endsection