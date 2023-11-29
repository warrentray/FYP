<?php

namespace App\Http\Controllers;

use App\Models\customer;
use App\Models\salary;
use App\Models\shift;
use App\Models\station;
use App\Models\user;

 use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
class adminController extends Controller
{
    
    public function manageStaff()
    {
         $users = User::with('station')->get();
         return view('admin.manageStaff', compact('users'));
    }
    
     public function changeStatus(Request $request)
     {
         $user = user::find($request->id);
 
         if (!$user) {
             return redirect()->route('manageStaff')->with('error', 'Staff not found.');
         }
 
         $newStatus = $request->new_status;
 
         if ($newStatus === 'Resign') {
             $user->status = 'Resign';
             $user->save();
             // Add any additional logic for handling Resignation (e.g., preventing login)
         } elseif ($newStatus === 'Normal') {
             $user->status = 'Normal';
             $user->save();
             // Add any additional logic for handling Normal status
         } else {
             return redirect()->route('manageStaff')->with('error', 'Invalid status provided.');
         }
 
         return redirect()->route('manageStaff')->with('success', 'Status updated successfully.');
     }
    public function addStaff()
    {
        $stations = station::all();
        $bonusTypes = ['None','Full_attendance', 'Retention_bonus', 'Referral_bonus', 'Signing_bonus'];
         $genders = ['Female', 'Male'];
         $defaultbonusType = 'None';
        $defaultgender= 'Female';
        return view('admin.addStaff', compact('stations','bonusTypes','genders','defaultbonusType','defaultgender'));
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customer|unique:user',
            'gender' => 'required',
            'Password' => ['required', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'],
            'confirm_password' => 'required|same:Password',
            'basic_salary' => 'required|numeric',
            'bonus_type' => 'required|in:None,Full_attendance,Retention_bonus,Referral_bonus,Signing_bonus',
            'bonus_amount' => 'required|numeric',
            'shiftType' => 'required',
            'ic' => 'required|regex:/^\d{6}-\d{2}-\d{4}$/ ',
        ], [
            'Confirm Password.same' => 'The Confirm Password must match the Password field.',
            'ic.regex' => 'The Identity Card format is invalid. It should be in the format xxxxxx-xx-xxxx.',
            'ic.unique' => 'The Identity Card is already taken.', // Add a custom message for unique rule

        ]);
        
        if ($validator->fails()) {
            return redirect('/addStaff')
                ->withErrors($validator)
                ->withInput();
        }
        

        if (DB::table('user')->count() == 0) {
            $id = 'S0000001';
           
        } else {
            $id = DB::table('user')->orderBy('id', 'desc')->value('id');
            $id = 'S' . sprintf('%07d', intval(substr($id, 6)) + 1);
         }

         if (DB::table('salary')->count() == 0) {
            $salaryId  = 'SY0000001';
        } else {
            $salaryId  = DB::table('salary')->orderBy('id', 'desc')->value('id');
            $salaryId  = 'SY' . sprintf('%07d', intval(substr($id, 6)) + 1);
         }
       
         if (DB::table('shift')->count() == 0) {
            $shiftId = 'SF0000001';
        } else {
            $shiftId = DB::table('shift')->orderBy('id', 'desc')->value('id');
            $shiftId = 'SF' . sprintf('%07d', intval(substr($shiftId, 6)) + 1);
            
         }

 
         $stationId = $request->input('stationName');

        

    // Create a new customer instance
    $shift = new Shift;
    $shift->id = $shiftId;
    $shift->ShiftType = $request->input('shiftType');  // Assign the correct field name
    $shift->ShiftChangeStatus = "Active";
    $shift->ChangeDate = now();
    $shift->Reason = 'null';
    $shift->save();

    $salary = new salary;
    $salary->id = $salaryId;
     $salary->basic_salary= $request->basic_salary;
    $salary->bonus_type= $request->input('bonus_type') ;
    $salary->bonus_amount= $request->bonus_amount;
    $salary->save();

     $user = new user;
    $user->id = $id;
    $user->name = $request->fullname;
    $user->email = $request->email;
    $user->identityCard =  $request->ic;
    $user->role = 'Staff';
    $user->gender = $request->input('gender');
    $user->password = Hash::make($request->Password);
    $user->token=0;
    $user->status='Normal';
    $user->shift_id =  $shiftId;
    $user->salary_id = $salaryId;
    $user->station_id = $stationId ;
    // Save the customer data
    $user->save(); 
    return redirect()->route('addStaff')->with('success', 'Staff account has been created.');
    }
    
    public function index3()
    {
        return view('admin.viewAttendance');
    }
    
     public function manageCusShow() {
      
        $customers = customer::all();
        return view('admin.manageCus', compact('customers'));
    }
     public function changeCustomerStatus(Request $request)
     {
         $customer = customer::find($request->id);
 
         if (!$customer) {
             return redirect()->route('manageCusShow')->with('error', 'Staff not found.');
         }
 
         $newStatus = $request->new_status;
 
         if ($newStatus === 'Active') {
             $customer->status = 'Active';
             $customer->save();
             // Add any additional logic for handling Resignation (e.g., preventing login)
         } elseif ($newStatus === 'Block') {
             $customer->status = 'Block';
             $customer->save();
             // Add any additional logic for handling Normal status
         } else {
             return redirect()->route('manageCusShow')->with('error', 'Invalid status provided.');
         }
 
         return redirect()->route('manageCusShow')->with('success', 'Status updated successfully.');
     }
    public function stationShow() {
      
        $stations = station::all();
        
        return view('admin.addStaff', compact('stations'));
    }
    public function logout() {
        Session::flush();
        Auth::logout();
  
        return Redirect('login');
    }
   
    }
