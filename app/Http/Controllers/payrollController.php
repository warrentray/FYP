<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Payslip;
use Illuminate\Support\Facades\DB;
use PDF;
use App\Models\salary; 

use App\Models\shift; 
use App\Models\staff_leave;
 use App\Models\medicalClaim;
use App\Models\station;
use App\Models\User; 
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use DateTime;

class payrollController extends Controller
{
    public function calPayslip()
    {
        return view('payslip.calculationPayslip');
    } 
    // public function generatePayslip()
    // {
    //     return view('payslip.generatePayslip');
    // } 
    public function payDash()
    {
        return view('payslip.payslipDash');
    } 
    public function salary($id)
    {    $user = User::find($id);
        $bonusTypes = ['None','Full_attendance', 'Retention_bonus', 'Referral_bonus', 'Signing_bonus'];
         $defaultbonusType = 'None';
        return view('payslip.salary', compact('bonusTypes','user','defaultbonusType'));
     } 

     public function updateSalary(Request $request, $id)
    {
        // Retrieve the petrol record by its ID
        $user = user::find($id);
    
        if (!$user) {
            // Handle the case where the record is not found
            return redirect()->route('salary', ['id' => $id])->with('fail', 'salary not found');
        } 
            // Form was submitted, continue with validation and saving to the database
            $validator = Validator::make($request->all(), [
                'basic_salary' => 'required|numeric',
                'bonus_type' => 'required|in:None,Full_attendance,Retention_bonus,Referral_bonus,Signing_bonus',
                'bonus_amount' => 'required|numeric',

            ],  );
    
            if ($validator->fails()) {
                return redirect()->route('salary', ['id' => $id])
                    ->withErrors($validator)
                    ->withInput();
            }
    
            // Update the petrol record with the new data
            $user->salary->update([
                'basic_salary' => $request->get('basic_salary'),
                'bonus_type' => $request->input('bonus_type'),
                'bonus_amount' => $request->get('bonus_amount'),
            ]);

            
            $bonusAmount = $request->get('bonusAmount');
            $medicalClaim = MedicalClaim::where('user_id', $user->id)->first();
            $leaveClaim = staff_leave::where('user_id', $user->id)->first();

            if (!empty($medicalClaim)) {
                if ($medicalClaim->claim_status === 'Approved') {
                    $claimAmount = $medicalClaim->amount;
                } else {
                    $claimAmount = 0;
                }
            } else {
                // Handle the case when $medicalClaim is empty
                $claimAmount = 0; // You can set any default value or handle it as needed
            }
            $basic_salary = $request->get('basic_salary');
            $bonus_amount= $request->get('bonus_amount');
            //cal leave 
            $leaveAmount = 0;

            if (!empty($leaveClaim)) {
                if ($leaveClaim->leaveType === "Non-pay leave" && $leaveClaim->status === "Approved") {
                    $leaveday = $leaveClaim->totalLeave;
            
                    // Check if $basic_salary and $leaveday are numeric before performing the calculation
                    if (is_numeric($basic_salary) && is_numeric($leaveday)) {
                        $calculatedLeaveAmount = ($basic_salary / 26 * $leaveday);
            
                        // Check if the calculated amount is numeric before adding it to $leaveAmount
                        if (is_numeric($calculatedLeaveAmount)) {
                            $leaveAmount += $calculatedLeaveAmount;
                            $leavedayAmount = number_format($calculatedLeaveAmount, 2);
                        } else {
                            $leaveAmount = 0;
                            $leavedayAmount = 0;
                        }
                    } else {
                        $leaveAmount = 0;
                        $leavedayAmount = 0;
                    }
                } else {
                    $leaveAmount = 0;
                    $leavedayAmount = 0;
                }
            } else {
                // Handle the case when $leaveClaim is empty
                $leaveAmount = 0; // You can set any default value or handle it as needed
                $leavedayAmount = 0;
            }
            
            
            $currentMonth = now()->subMonth()->format('m');
            $currentYear = now()->format('Y');
            $shiftid = shift::where('id', $user->shift_id)->first(); // Use first() to get a single model
           $shiftType= $shiftid->ShiftType;
 
            $MorningSignInTime = '06:00:00'; // Adjust the time as needed
        $AfternoonSignInTime ='16:00:00';
        $nightSignInTime = '00:00:00';

        // Get all attendances for the specified user, month, and year
        $attendances = Attendance::where('user_id', $user->id)
        ->whereMonth('sign_in_time', $currentMonth)
        ->whereYear('sign_in_time', $currentYear)  
            ->get();
            if ($attendances->isEmpty()) {
                Alert::error('Fail', 'No attendance records found');

                return redirect()->route('salary', ['id' => $id]);
            }
        
        // Variables for calculating total salary
        $expectedWorkingHours = 9; // Adjust based on your requirements
        $overtimeRate = 1.5;
 
        // Initialize total salary
        $overtimePay=0; $totalSalary=0;$earlyDepartureDeduction=0;
        foreach ($attendances as $attendance) {
            // Convert sign-in and sign-out times to DateTime objects
            $signInTime = new DateTime($attendance->sign_in_time);
            $signOutTime = new DateTime($attendance->sign_out_time);
 
             
            $station= $user->station->name;
              // Calculate lateness (positive value if late, zero if on time or early)
             if ($shiftType === 'morning') { 
                $lateness = max(0, $signInTime->diff(new DateTime("$attendance->date $MorningSignInTime"))->i); 
                $expectedSignOutTime = new DateTime("$attendance->date $MorningSignInTime");
                $expectedSignOutTime->modify("+9 hours");
            }elseif($shiftType ==='afternoon')
            {
                $lateness = max(0, $signInTime->diff(new DateTime("$attendance->date $AfternoonSignInTime"))->i);
                $expectedSignOutTime = new DateTime("$attendance->date $AfternoonSignInTime");
                $expectedSignOutTime->modify("+9 hours");
            }else {
                $lateness = max(0, $signInTime->diff(new DateTime("$attendance->date $nightSignInTime"))->i);
                $expectedSignOutTime = new DateTime("$attendance->date $nightSignInTime");
                $expectedSignOutTime->modify("+9 hours");
            }
            $earlyDepartureDeduction=0;
            $actualWorkingHours = round($signInTime->diff($signOutTime)->h);

             // Calculate overtime (hours worked beyond the expected working hours)
            $overtime = max(0, $actualWorkingHours - $expectedWorkingHours);
            
            $overtimePay += number_format(($overtime*$overtimeRate) * ($basic_salary / 26 /9), 2);
            $earlyDeparture = max(0, $expectedWorkingHours - $actualWorkingHours);
            $earlyDepartureDeduction = number_format($earlyDeparture * ($basic_salary / 26 / 9), 2);
             $late=0;
 
              // Check if there was full attendance and no lateness
              if (is_numeric($basic_salary) && is_numeric($overtimePay) && is_numeric($earlyDepartureDeduction)) {
                if ($actualWorkingHours >= $expectedWorkingHours && $lateness === 0) {
                     $totalSalary = $basic_salary + $overtimePay - $earlyDepartureDeduction;
                 } elseif ($actualWorkingHours >= $expectedWorkingHours && $lateness !== 0) {
                    $totalSalary = $basic_salary + $overtimePay - $earlyDepartureDeduction - 100;
                    $late=100;
                 } else {
                    $totalSalary = $basic_salary + $overtimePay;
 
                }
            } else {
                 $totalSalary = 0; // Change this to an appropriate default value
 
            }

            $totalSalary = is_numeric($totalSalary) ? $totalSalary : 0;
        $bonusAmount = is_numeric($bonusAmount) ? $bonusAmount : 0;
        $claimAmount = is_numeric($claimAmount) ? $claimAmount : 0;
         $basic_salary = is_numeric($user->salary) ? $user->salary : 0;

             $totalamount=  ceil($totalSalary + $bonusAmount+  $claimAmount+ $leaveAmount-$basic_salary);
             $useryear = substr($user->identityCard, 0, 2);
             $century = ($useryear >= 00) ? "20" : "19";
             $birthYear = $century . $useryear;


            // $totalSalary = $user->salary + $bonusAmount+ $medicalClaim->amount;
                $age= $currentYear-$birthYear;
             $epfContributions = $this->calculateEPFContributions( $totalamount,$age);
            
             if (DB::table('payslip')->count() == 0) {
                $payslipid = 'PY0000001';
            } else {
                $lastPayslip = DB::table('payslip')->orderBy('id', 'desc')->first();
                $lastPayslipId = $lastPayslip->id;
            
                // Extract the numeric part and increment
                $numericPart = intval(substr($lastPayslipId, 2));
                $newNumericPart = $numericPart + 1;
            
                // Format the new id
                $payslipid = 'PY' . sprintf('%07d', $newNumericPart);
            }
            $eisContribution = $this->calculateEISContribution($totalamount);
             $contribution = $this->calculateContribution($totalamount);
             $total_amount = $totalamount - $leaveAmount + $overtimePay;

             $netamount = number_format(ceil(($totalamount - $leaveAmount + $overtimePay - $eisContribution - $contribution['employee'] - $epfContributions['employee'])), 2, '.', '');
             $payslip=new payslip;
            $payslip->id= $payslipid;
            $payslip->date= now();
            $payslip->total_amount= ceil($total_amount);
            $payslip->epf=  ceil($epfContributions['employee']);
            $payslip->SOCSO= ceil($contribution['employee']);
            $payslip->EIS= $eisContribution;

            $payslip->leave_amount= $leaveAmount;
            $payslip->medical_amount= $claimAmount;
            $payslip->netAmount= $netamount; 
            $payslip->leave_id= $leaveClaim->leave_id;
             $payslip->user_id= $user->id;
            $payslip->save();  
            Alert::success('success', 'Salary information updated successfully');
            return view('payslip.pdf', compact('user', 'station', 'eisContribution', 'claimAmount','late', 'basic_salary', 'bonus_amount', 'overtimePay', 'epfContributions', 'contribution', 'leaveAmount', 'claimAmount'));
        }
}

// public function generatePayslip($id)
// {
//     // Fetch the user and relevant data (modify this based on your application)
//     $user = User::find($id);

//     // Generate PDF view
//     $pdf = PDF::loadView('payslip.pdf', [
//         'user' => $user,
//         'station' =>  $user->station->name, 
//         'totalSalary' => $user->salary->total_amount,  
//         'overtimePay' => $user->salary->total_amoun, // Change this to your overtime data
//         'epfContributions' => ['employee' => 50], // Change this to your EPF data
//         'contribution' => ['employee' => 30], // Change this to your SOCSO data
//         'leaveAmount' => 10, // Change this to your leave amount data
//     ]);

//     // Download the PDF file
//     return $pdf->download('payslip.pdf');
// }

      public function viewPayslipInfo()
    {
        $userId = session('user')['id'];
         $user=user::find($userId);
         $payslip=payslip::where('user_id',$userId)->first();
          $basic_salary=  $user->salary->basic_salary;
        $medicalClaim = MedicalClaim::where('user_id', $userId)->first();
        $leaveClaim = staff_leave::where('user_id', $userId)->first();

        if (!empty($medicalClaim)) {
            if ($medicalClaim->claim_status === 'Approved') {
                $claimAmount = $medicalClaim->amount;
            } else {
                $claimAmount = 0;
            }
        } else {
            // Handle the case when $medicalClaim is empty
            $claimAmount = 0; // You can set any default value or handle it as needed
        }
        $leaveAmount = 0;

        if (!empty($leaveClaim)) {
            if ($leaveClaim->leaveType === "Non-pay leave" && $leaveClaim->status === "Approved") {
                $leaveday = $leaveClaim->totalLeave;
        
                // Check if $basic_salary and $leaveday are numeric before performing the calculation
                if (is_numeric($basic_salary) && is_numeric($leaveday)) {
                    $calculatedLeaveAmount = ($basic_salary / 26 * $leaveday);
        
                    // Check if the calculated amount is numeric before adding it to $leaveAmount
                    if (is_numeric($calculatedLeaveAmount)) {
                        $leaveAmount += $calculatedLeaveAmount;
                        $leavedayAmount = number_format($calculatedLeaveAmount, 2);
                    } else {
                        $leaveAmount = 0;
                        $leavedayAmount = 0;
                    }
                } else {
                    $leaveAmount = 0;
                    $leavedayAmount = 0;
                }
            } else {
                $leaveAmount = 0;
                $leavedayAmount = 0;
            }
        } else {
            // Handle the case when $leaveClaim is empty
            $leaveAmount = 0; // You can set any default value or handle it as needed
            $leavedayAmount = 0;
        }
        $currentMonth = now()->subMonth()->format('m');
        $currentYear = now()->format('Y');
        $shiftid = shift::where('id', $user->shift_id)->first(); // Use first() to get a single model
       $shiftType= $shiftid->ShiftType;

        $MorningSignInTime = '06:00:00'; // Adjust the time as needed
    $AfternoonSignInTime ='16:00:00';
    $nightSignInTime = '00:00:00';

    // Get all attendances for the specified user, month, and year
    $attendances = Attendance::where('user_id', $user->id)
    ->whereMonth('sign_in_time', $currentMonth)
    ->whereYear('sign_in_time', $currentYear)  
        ->get();
        if ($attendances->isEmpty()) {
            Alert::error('Fail', 'No attendance records found');

            return redirect()->route('salary', ['id' => $userId]);
        }
    
    // Variables for calculating total salary
    $expectedWorkingHours = 9; // Adjust based on your requirements
    $overtimeRate = 1.5;

    // Initialize total salary
    $overtimePay=0; $totalSalary=0;$earlyDepartureDeduction=0;
    foreach ($attendances as $attendance) {
        // Convert sign-in and sign-out times to DateTime objects
        $signInTime = new DateTime($attendance->sign_in_time);
        $signOutTime = new DateTime($attendance->sign_out_time);

         
        $station= $user->station->name;
          // Calculate lateness (positive value if late, zero if on time or early)
         if ($shiftType === 'morning') { 
            $lateness = max(0, $signInTime->diff(new DateTime("$attendance->date $MorningSignInTime"))->i); 
            $expectedSignOutTime = new DateTime("$attendance->date $MorningSignInTime");
            $expectedSignOutTime->modify("+9 hours");
        }elseif($shiftType ==='afternoon')
        {
            $lateness = max(0, $signInTime->diff(new DateTime("$attendance->date $AfternoonSignInTime"))->i);
            $expectedSignOutTime = new DateTime("$attendance->date $AfternoonSignInTime");
            $expectedSignOutTime->modify("+9 hours");
        }else {
            $lateness = max(0, $signInTime->diff(new DateTime("$attendance->date $nightSignInTime"))->i);
            $expectedSignOutTime = new DateTime("$attendance->date $nightSignInTime");
            $expectedSignOutTime->modify("+9 hours");
        }
        $earlyDepartureDeduction=0;
        $actualWorkingHours = round($signInTime->diff($signOutTime)->h);

         // Calculate overtime (hours worked beyond the expected working hours)
        $overtime = max(0, $actualWorkingHours - $expectedWorkingHours);
        
        $overtimePay += number_format(($overtime*$overtimeRate) * ($basic_salary / 26 /9), 2);
        $earlyDeparture = max(0, $expectedWorkingHours - $actualWorkingHours);
        $earlyDepartureDeduction = number_format($earlyDeparture * ($basic_salary / 26 / 9), 2);
         $late=0;

          // Check if there was full attendance and no lateness
          if (is_numeric($basic_salary) && is_numeric($overtimePay) && is_numeric($earlyDepartureDeduction)) {
            if ($actualWorkingHours >= $expectedWorkingHours && $lateness === 0) {
                 $totalSalary = $basic_salary + $overtimePay - $earlyDepartureDeduction;
             } elseif ($actualWorkingHours >= $expectedWorkingHours && $lateness !== 0) {
                $totalSalary = $basic_salary + $overtimePay - $earlyDepartureDeduction - 100;
                $late=100;
             } else {
                $totalSalary = $basic_salary + $overtimePay;

            }
        } else {
             $totalSalary = 0; // Change this to an appropriate default value

        }
        return view('payslip.viewPayslipInfo', compact('user', 'station',  'payslip', 'late', 'basic_salary', 'overtimePay',  'leaveAmount', 'claimAmount'));
    } }
    public function AdminDashboardPayslip()
    {
        return view('payslip.adminPayslipDash');
    }  public function cal()
    {
        return view('payslip.cal');
    } 
    public function getStationStaff($id)
    {
        $stationStaff = User::where('station_id', $id)->get();
        $user = User::find($id);

        return view('payslip.salary', compact('stationStaff','user'));
    }
   
    function calculateEPFContributions($id,$age)
{
    // Define EPF rates for employees and employers
    $employeeRateBelow60 = 0.09; // 9%
    $employerRateBelow60 = 0.13; // 13%
    
    $employeeRateAbove60 = 0.04; // 4%
    $employerRateAbove60 = 0;    // 0% for employer's share

    // Define EPF contribution limit
    $epfContributionLimit = 5000;

    // Initialize contributions
    $employeeContribution = 0;
    $employerContribution = 0;

    // Determine the EPF contributions based on age and salary
    if ($age < 60) {
        $employeeContribution = min($id, $epfContributionLimit) * $employeeRateBelow60;
        $employerContribution = min($id, $epfContributionLimit) * $employerRateBelow60;
    } else {
        $employeeContribution = min($id, $epfContributionLimit) * $employeeRateAbove60;
        $employerContribution = min($id, $epfContributionLimit) * $employerRateAbove60;
    }

    // Return the contributions as an associative array
    return [
        'employee' => $employeeContribution,
        'employer' => $employerContribution,
    ];
}
    function calculateEISContribution($id)
{
     $salaryRanges = [
        1000 => 2.10,
        1100 => 2.30,
        1200 => 2.50,
        1300 => 2.70,
        1400 => 2.90,
        1500 => 3.10,
        1600 => 3.30,
        1700 => 3.50,
        1800 => 3.70,
        1900 => 3.90,
        2000 => 4.10,
        2100 => 4.30,
        2200 => 4.50,
        2300 => 4.70,
        2400 => 4.90,
        2500 => 5.10,
        2600 => 5.30,
        2700 => 5.50,
        2800 => 5.70,
        2900 => 5.90,
        3000 => 6.10,
        3100 => 6.30,
        3200 => 6.50,
        3300 => 6.70,
        3400 => 6.90,
        3500 => 7.10,
        3600 => 7.30,
        3700 => 7.50,
        3800 => 7.70,
        3900 => 7.90,
        4000 => 7.90,
        PHP_INT_MAX => 7.90, // For salaries above 4000
    ];

    // Find the appropriate range for the given salary
    $contribution = null;
    foreach ($salaryRanges as $range => $rate) {
        if ($id <= $range) {
            $contribution = $rate;
            break;
        }
    }

    return $contribution;
}
function calculateContribution($monthlyWage)
{
    $categories = [
        ['maxWage' => 30, 'employer' => 0.40, 'employee' => 0.10],
        ['maxWage' => 50, 'employer' => 0.70, 'employee' => 0.20],
        ['maxWage' => 70, 'employer' => 1.10, 'employee' => 0.30],
        ['maxWage' => 100, 'employer' => 1.50, 'employee' => 0.40],
        ['maxWage' => 140, 'employer' => 2.10, 'employee' => 0.60],
        ['maxWage' => 200, 'employer' => 2.95, 'employee' => 0.85],
        ['maxWage' => 300, 'employer' => 4.35, 'employee' => 1.25],
        ['maxWage' => 400, 'employer' => 6.15, 'employee' => 1.75],
        ['maxWage' => 500, 'employer' => 7.85, 'employee' => 2.25],
        ['maxWage' => 600, 'employer' => 9.65, 'employee' => 2.75],
        ['maxWage' => 700, 'employer' => 11.35, 'employee' => 3.25],
        ['maxWage' => 800, 'employer' => 13.15, 'employee' => 3.75],
        ['maxWage' => 900, 'employer' => 14.85, 'employee' => 4.25],
        ['maxWage' => 1000, 'employer' => 16.65, 'employee' => 4.75],
        ['maxWage' => 1100, 'employer' => 18.35, 'employee' => 5.25],
        ['maxWage' => 1200, 'employer' => 20.15, 'employee' => 5.75],
        ['maxWage' => 1300, 'employer' => 21.85, 'employee' => 6.25],
        ['maxWage' => 1400, 'employer' => 23.65, 'employee' => 6.75],
        ['maxWage' => 1500, 'employer' => 25.35, 'employee' => 7.25],
        ['maxWage' => 1600, 'employer' => 27.15, 'employee' => 7.75],
        ['maxWage' => 1700, 'employer' => 28.85, 'employee' => 8.25],
        ['maxWage' => 1800, 'employer' => 30.65, 'employee' => 8.75],
        ['maxWage' => 1900, 'employer' => 32.35, 'employee' => 9.25],
        ['maxWage' => 2000, 'employer' => 34.15, 'employee' => 9.75],
        ['maxWage' => 2100, 'employer' => 35.85, 'employee' => 10.25],
        ['maxWage' => 2200, 'employer' => 37.65, 'employee' => 10.75],
        ['maxWage' => 2300, 'employer' => 39.35, 'employee' => 11.25],
        ['maxWage' => 2400, 'employer' => 41.15, 'employee' => 11.75],
        ['maxWage' => 2500, 'employer' => 42.85, 'employee' => 12.25],
        ['maxWage' => 2600, 'employer' => 44.65, 'employee' => 12.75],
        ['maxWage' => 2700, 'employer' => 46.35, 'employee' => 13.25],
        ['maxWage' => 2800, 'employer' => 48.15, 'employee' => 13.75],
        ['maxWage' => 2900, 'employer' => 49.85, 'employee' => 14.25],
        ['maxWage' => 3000, 'employer' => 51.65, 'employee' => 14.75],
        ['maxWage' => 3100, 'employer' => 53.35, 'employee' => 15.25],
        ['maxWage' => 3200, 'employer' => 55.15, 'employee' => 15.75],
        ['maxWage' => 3300, 'employer' => 56.85, 'employee' => 16.25],
        ['maxWage' => 3400, 'employer' => 58.65, 'employee' => 16.75],
        ['maxWage' => 3500, 'employer' => 60.35, 'employee' => 17.25],
        ['maxWage' => 3600, 'employer' => 62.15, 'employee' => 17.75],
        ['maxWage' => 3700, 'employer' => 63.85, 'employee' => 18.25],
        ['maxWage' => 3800, 'employer' => 65.65, 'employee' => 18.75],
        ['maxWage' => 3900, 'employer' => 67.35, 'employee' => 19.25],
        ['maxWage' => 4000, 'employer' => 69.15, 'employee' => 19.75],
        ['maxWage' => 4100, 'employer' => 70.85, 'employee' => 20.25],
        ['maxWage' => 4200, 'employer' => 72.65, 'employee' => 20.75],
        ['maxWage' => 4300, 'employer' => 74.35, 'employee' => 21.25],
        ['maxWage' => 4400, 'employer' => 76.15, 'employee' => 21.75],
        ['maxWage' => 4500, 'employer' => 77.85, 'employee' => 22.25],
        ['maxWage' => 4600, 'employer' => 79.65, 'employee' => 22.75],
        ['maxWage' => 4700, 'employer' => 81.35, 'employee' => 23.25],
        ['maxWage' => 4800, 'employer' => 83.15, 'employee' => 23.75],
        ['maxWage' => 4900, 'employer' => 84.85, 'employee' => 24.25],
        ['maxWage' => 5000, 'employer' => 86.65, 'employee' => 24.75],
        ['maxWage' => PHP_INT_MAX, 'employer' => 86.65, 'employee' => 24.75],
    ];

    foreach ($categories as $category) {
        if ($monthlyWage <= $category['maxWage']) {
            return [
                'employer' => $category['employer'],
                'employee' => $category['employee'],
            ];
        }
    }

    return [
        'employer' => 0,
        'employee' => 0,
    ];
}


public function getStaff(Request $request)
{
    $station_id = $request->station_id;

    if (!$station_id) {
        return response()->json(['error' => 'Please select a station.']);
    }

    $station = Station::find($station_id);
    $staff = $station->staff;

    return response()->json(['staff' => $staff]);
}
}
