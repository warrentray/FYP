<title>Payslip</title>
@extends('layouts.master')

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

@section('content')
@include('sweetalert::alert')
<style>
    body {
        font-family: Arial, sans-serif;
    }

    .payslip-container {
        width: 80%;
        margin: 0 auto;
        border: 1px solid #000;
        padding: 20px;
    }

    .payslip-info {
        display: flex;
        justify-content: space-between;
    }

    .payslip-table {
        width: 100%;
        margin-top: 20px;
        border-collapse: collapse;
    }

    .payslip-table th,
    .payslip-table td {
        border: 1px solid #000;
        padding: 10px;
        text-align: center;
    }
</style>
</head>


<body>
    <div class="payslip-container">
        <div class="payslip-info">
            <h1>Payslip</h1>
            <p>{{ now()->format('F Y') }}</p>
        </div>
        <div class="payslip-info">

            <p>Staff: {{ $user->name }}</p>
            <p>Employee ID: {{ $user->id }}</p>
        </div>
        <table class="payslip-table">
            {{-- <div style="text-align: center; margin-top: 20px;">
                <a href="{{ route('generate-payslip', ['id' => $user->id]) }}" class="btn btn-primary"
                    download="payslip.pdf">Download PDF</a>


            </div> --}}
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Amount (RM)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Basic Salary</td>
                    <td>{{ number_format($user->salary->basic_salary, 2) }}</td>
                </tr>
                <tr>
                    <td>Bonus amount</td>
                    <td>{{ $user->salary->bonus_amount }}</td>
                </tr>
                <tr>
                    <td>Leave Amount (non pay leave)</td>
                    <td>- {{ number_format($leaveAmount, 2) }}</td>
                </tr>
                <tr>
                    <td>Medical Calim</td>
                    <td>+ {{ ($payslip->medical_amount) }}</td>
                </tr>
                <tr>
                    <td>Late (Late for sign in)</td>
                    <td>- {{ number_format($late, 2) }}</td>
                </tr>
                <tr>
                    <td>Overtime Pay</td>
                    <td>+ {{ number_format($overtimePay, 2) }}</td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td>{{ number_format($user->salary->basic_salary - $leaveAmount +$payslip->medical_amount+
                        $overtimePay, 2) }}</td>
                </tr>
                <tr>
                    <td>EPF</td>
                    <td>- {{ $payslip->epf }}</td>
                </tr>
                <tr>
                    <td>SOCSO</td>
                    <td>- {{ $payslip->SOCSO }}</td>
                </tr>
                <tr>
                    <td>EIS</td>
                    <td>- {{ number_format($payslip->EIS, 2) }}</td>
                </tr>
                <tr>
                    <td>Net Salary</td>
                    <td>RM {{ number_format($user->salary->basic_salary - $leaveAmount + $overtimePay -
                        $payslip->epf -
                        $payslip->SOCSO - $payslip->EIS+$claimAmount , 2) }}</td>
                </tr>
            </tbody>
        </table>
        {{-- <div class="container-fluid">

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold  " style="font-size:20px; color:black;"><b>Payslip</b>
                    </h6>
                </div>
                <div class=" card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Staff: </th>
                                    <th>Employee ID:</th>
                                    <th>Basic Salary</th>
                                    <th>Bonus amount</th>
                                    <th>Leave Amount (non pay leave) </th>
                                    <th>Late (Late for sign in) </th>
                                    <th>Overtime Pay</th>
                                    <th>Total</th>
                                    <th>EPF </th>
                                    <th>SOCSO</th>
                                    <th>EIS </th>
                                    <th>Net Salary</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ number_format($user->salary->basic_salary, 2) }}</td>
                                    <td>{{ number_format($bonus_amount, 2) }}</td>
                                    <td>- {{ number_format($leaveAmount, 2) }}</td>
                                    <td>- {{ number_format($late, 2) }}</td>
                                    <td>+ {{ number_format($overtimePay, 2) }}</td>
                                    <td>{{ number_format($user->salary->basic_salary - $leaveAmount + $overtimePay, 2)
                                        }}
                                    </td>
                                    <td>- {{ number_format($epfContributions['employee'], 2) }}</td>

                                    <td>- {{ number_format($contribution['employee'], 2) }}</td>
                                    <td>- {{ number_format($eisContribution , 2) }}</td>
                                    <td>RM {{ number_format($user->salary->basic_salary - $leaveAmount + $overtimePay -
                                        $epfContributions['employee'] -
                                        $contribution['employee'] - $eisContribution , 2) }}</td>

                                </tr>

                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>

</body>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5', 'csvHtml5', 'excelHtml5', 'pdfHtml5', 'printHtml5'
            ]
        });
    });
</script> --}}

@endsection