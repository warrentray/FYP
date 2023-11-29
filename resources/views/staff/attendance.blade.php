<title>Attendance</title>
@extends('layouts.master')
<script src="https://cdn.jsdelivr.net/npm/instascan@1.0.0"></script>
<script src="https://unpkg.com/html5-qrcode"></script>

@section('content')
<video id="preview"></video>

<div class="container text-dark">
    <div class="row">
        <div class="myform form">
            <div class="col-md-12 text-left mb-5">
                <h1><b>Attendance</b></h1>
                <hr>
                <h2>Station Name: Setapak Station</h2>
            </div>
        </div>
    </div>
    <div id="locationInfo" class="container text-center mt-4">

    </div>
    <form id="attendanceForm" action="{{ route('attendance.store') }}" method="post">
        @csrf
        <input type="hidden" name="qr_code" id="qrCodeInput">

        <div class="container text-center">
            <button id="signInBtn" class="btn btn-warning text mb-4"
                style="width: 40%; font-size: 24px; padding: 20px;">
                Sign In
            </button>
        </div>

        <div class="container text-center">
            <button id="signOutBtn" class="btn btn-warning text mt-4"
                style="width: 40%; font-size: 24px; padding: 20px;" disabled>
                Sign Out
            </button>
        </div>
        <div id="reader" width="600px"></div>

        <!-- Display the map -->
        <div id="map" style="height: 400px; margin-top: 20px;"></div>
    </form>
</div>

<script>
    function onScanSuccess(decodedText, decodedResult) {
        // handle the scanned code as you like, for example:
        console.log(`Code matched = ${decodedText}`, decodedResult);
        
        // Set the scanned QR code value in a hidden input field
        document.getElementById('qrCodeInput').value = decodedText;

        // Disable the scanner after successful scan
        html5QrcodeScanner.clear();
        
        // Enable the sign-in button
        document.getElementById('signInBtn').disabled = false;
    }

    let config = {
        fps: 60,
        qrbox: { width: 500, height: 500 },
        rememberLastUsedCamera: true,
        // Only support camera scan type.
        supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA]
    };

    let html5QrcodeScanner = new Html5QrcodeScanner(
        "reader", config, /* verbose= */ false);
    html5QrcodeScanner.render(onScanSuccess);

    // Attach a click event listener to the Sign In button
    document.getElementById('signInBtn').addEventListener('click', function () {
        // Disable the sign-in button
        this.disabled = true;
        
        // Perform AJAX request to store attendance
        let form = document.getElementById('attendanceForm');
        let formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            // Handle the response as needed
            console.log(data);
        })
        .catch(error => console.error('Error:', error));
    });

    let scannedCode = "Segamat Store";

// Assuming you are using jQuery for simplicity
$.ajax({
    url: ' attendance.store ',  
    method: 'POST',
    data: {
        _token: '{{ csrf_token() }}', // Include CSRF token if using Laravel
        qr_code: scannedCode
    },
    success: function(response) {
        console.log(response); // Handle success response
    },
    error: function(error) {
        console.error(error); // Handle error
    }
});
</script>

@endsection