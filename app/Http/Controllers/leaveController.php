<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\leave;
use App\Models\staff_leave;
use App\Models\station;
use App\Models\user;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use Session;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class leaveController extends Controller
{
    public function applyLeave()
    {
        if (!session('user')) {
            if (session('customer')) {
                return redirect('login')->with('error', 'Illegitimate Access! You cannot access this page.');
            }
            return redirect('login')->with('error', 'Please login to continue.');
        }
         

        $leaveTypes = leave::all();

        // Fetch leave balance for the current user
        $userId = session('user')['id'];
        $userLeaveBalances= staff_leave::where('user_id', $userId)->get();

     
         return view('leave.applyleave', compact('leaveTypes', 'userLeaveBalances'));
 
    }
 
    public function storeApplyLeave(Request $request)
{
    $user = session('user');

    $request->validate([
         'startDate' => ['required', 'date', 'after_or_equal:today'],
        'endDate' => ['required', 'date', 'after_or_equal:endDate'],
        'leaveReason' => 'required',
    ], [
         'startDate.required' => 'The start date is required.',
        'startDate.date' => 'Invalid format for the start date.',
        'startDate.after_or_equal' => 'The start date must be today or in the future.',
        'endDate.required' => 'The end date is required.',
        'endDate.date' => 'Invalid format for the end date.',
        'endDate.after_or_equal' => 'The end date must be equal to or after the start date.',
        'leaveReason.required' => 'The leave reason is required.',
    ]);
 
    $startDate = Carbon::parse($request->startDate);
    $applyEndDate = Carbon::parse($request->endDate);
    $isEmergencyLeave = $request->leaveType === 'Emergency Leave';

    $minimumStartDate = now()->addDays(4);
 
    if (!$isEmergencyLeave && $startDate->lessThan($minimumStartDate)) {
        $formattedMinimumStartDate = $minimumStartDate->format('Y-m-d');
        
        return redirect()->back()->withErrors([
            'startDate' => "Apply date must be at least 4 days from the current date. Start date: $formattedMinimumStartDate"
        ])->withInput();
    }
    $totalLeave = $applyEndDate->diffInDays($startDate)+1;
    $leaveType = $request->leaveType;  
    $overlappingLeave = Staff_Leave::where('user_id', $user['id'])
    ->where(function ($query) use ($startDate, $applyEndDate) {
        $query->where(function ($q) use ($startDate, $applyEndDate) {
            $q->where('applyStartDate', '>=', $startDate)
                ->where('applyStartDate', '<=', $applyEndDate);
        })->orWhere(function ($q) use ($startDate, $applyEndDate) {
            $q->where('applyEndDate', '>=', $startDate)
                ->where('applyEndDate', '<=', $applyEndDate);
        });
    })
    ->exists();
    if ($overlappingLeave) {
        return redirect()->back()->withErrors([
            'startDate' => 'Leave application overlaps with existing leave records.'
        ])->withInput();
    }
    $leave = Leave::where('leave_type', 'like', $request->leaveType)->first();
    $totalNumber = Leave::where('leave_type', $leaveType)->value('totalNumber');
     
    $leaveBalZero = Staff_Leave::where('leaveBal', 0)
    ->where('leaveType', 'like', $request->leaveType)
    ->where('user_id', $user['id'])
    ->exists();
   
     $leaveBal = max(0, $totalNumber - $totalLeave);
     //FIND THE STAFF LEAVE ID 
    if (DB::table('staff_leave')->count() == 0) {
    $id = 'SL00000001';
    } else {
    $id = DB::table('staff_leave')->orderBy('id', 'desc')->value('id');
    $id = 'SL' . sprintf('%08d', intval(substr($id, 7)) + 1);
    }
    if ($startDate->greaterThan($applyEndDate)) {
        return redirect()->back()->withErrors([
            'startDate' => 'Start date must be before the end date.'
        ])->withInput();
    }
    // Check if the leave record is found
    if ($leave) {
        // Check if $leave is an instance of the expected model
        if ($leave instanceof Leave) {
            // Check if leave balance is zero
            if ($leaveBalZero) {
                return redirect()->back()->withErrors([
                    'leaveReason' => "Cannot apply leave for $leaveType. Leave balance is zero."
                ])->withInput();
            }
           
            if ($totalLeave > $leaveBal) {
                return redirect()->back()->withErrors([
                    'endDate' => "Selected end date exceeds available days. Maximum available days: $leaveBal"
                ])->withInput();
            }
            $reason = $request->input('leaveReason');

            $staffLeave = new Staff_Leave([
                'id' => $id,
                'leaveType' => $leaveType,
                'totalLeave' => $totalLeave,
                'leaveBal' => $leaveBal,
                'reason' => $reason,
                'applyStartDate' => $startDate,
                'applyEndDate' => $applyEndDate,
                'status' => 'Pending',
                'leave_id' => $leave->id,
                'user_id' => $user['id'],
            ]);

            $staffLeave->save();

            Alert::success('Congratulations', 'Apply leave Successfully');
            return redirect('/leaveHistory');
        } else {
            return response()->json(['error' => 'Invalid leave record'], 422);
        }
    } else {
        return response()->json(['error' => 'Leave record not found'], 404);
    }
}
    
    
     public function viewLeave()
    {
        $stations= station::all();
        $staff_leave = staff_leave::all();
        $users=user::all();
        return view('leave.viewLeave',compact('stations','staff_leave','users'));
    }
    public function leaveHistory()
    {
        $sessionId = session()->getId();
        
        // Check if the user is not authenticated
        if (!session('user')) {
            return redirect('../login')->with('error', 'Please login to do the further action.');
        }
        
        // Retrieve user data from the session
        $user = session('user');
        
        // Check if the session ID matches the user's session ID
        if ($user['session_id'] == $sessionId) {
            // Retrieve leave history based on the user's ID
            $staff_leave = Staff_Leave::where('user_id', $user['id'])->get();
            
            // The session ID matches, proceed with the leave history view
            return response()->view('leave.leaveHistory', ['staff_leave' => $staff_leave, 'user' => $user, 'sessionId' => $sessionId]);
        } else {
            // If the session ID doesn't match, log the user out and redirect to login
            Session::forget('user');
            return redirect('../login')->with('error', 'Session mismatch, please login again.');
        }
    }
    
    public function approveLeave($leave_id)
    {     
                        $result = DB::table('staff_leave')
                            ->where('leave_id', $leave_id)
                            ->update([
                                
                                'status' => 'Approved',
                                'updated_at' => now(),
                            ]);
    
                        if ($result) {
                            // Commit the transaction if everything is successful
                            DB::commit();
                            Alert::success('Congratulations', 'Leave approved successfully');
                        } else {
                            Alert::error('Error', 'Failed to approve leave');
                        }
                    
    
        // Redirect to the appropriate page
        return redirect('viewLeave');
    }
    public function rejectLeave($leave_id)
    {
 
    // Check if the leave request start date is equal to the current date
    $totalNumber = Leave::where('id', $leave_id)->value('totalNumber');
    $totalDay = staff_Leave::where('leave_id', $leave_id)->value('totalLeave');
    $leaveBal = max(0, $totalNumber + $totalDay);
        
            $result = DB::table('staff_leave')
            ->where('leave_id', $leave_id)
            ->update([
                'leaveBal' => $leaveBal,
                'status' => 'Rejected',
                'updated_at' => now(),
            ]);

        
            Alert::success('Congratulations', 'Leave rejected successfully');
       
    return redirect('viewLeave');
}
    
    public function dashApply()
    {  
        if (!session('user')) {
            if (session('customer')) {
                return redirect('login')->with('error', 'Illegitimate Access! You cannot access this page.');
            }
            return redirect('login')->with('error', 'Please login to continue.');
        }
    
        // Check if the user is a manager
      
        $leaveTypes = leave::all(); 

        // Fetch leave balance for the current user
        $userId = session('user')['id'];
        $userLeaveBalances= staff_leave::where('user_id', $userId)->get();
     
        // Return the view with leaveTypes and leaveBal data
        
        return view('leave.dashApplyLeave', compact('leaveTypes', 'userLeaveBalances'));
    }
    
    

    public function editLeave($leave_id)
    {
        // Retrieve the leave record based on the leave_id
        $staffLeave = Staff_Leave::find($leave_id);
    
        // Check if the leave record exists
        if (!$staffLeave) {
            return redirect('leaveHistory')->with('error', 'Leave record not found.');
        }
    
        // Check if the leave record status is 'Pending'
        if ($staffLeave->status !== 'Pending') {
            return redirect('leaveHistory')->with('error', 'Cannot edit leave. Leave status is not Pending.');
        }
    
        // Fetch leave types and user leave balances
        $leaveTypes = Leave::all();  // Assuming Leave is the model for your leave types
        $userId = session('user')['id'];
        $userLeaveBalances = Staff_Leave::where('user_id', $userId)->get();
    
        // Pass the leave record and other necessary data to the view
        return view('leave.editLeave', compact('staffLeave', 'leaveTypes', 'userLeaveBalances'));
    }

public function updateLeave(Request $request, $leave_id)
{
    $user = session('user');
    // Validate the request data
    $request->validate([
        'startDate' => ['required', 'date', 'after_or_equal:today'],
        'endDate' => ['required', 'date', 'after_or_equal:endDate'],
        'leaveReason' => 'required',
        // Add any other validation rules as needed
    ], [
        'startDate.required' => 'The start date is required.',
        'startDate.date' => 'Invalid format for the start date.',
        'startDate.after_or_equal' => 'The start date must be today or in the future.',
        'endDate.required' => 'The end date is required.',
        'endDate.date' => 'Invalid format for the end date.',
        'endDate.after_or_equal' => 'The end date must be equal to or after the start date.',
        'leaveReason.required' => 'The leave reason is required.',
        // Add custom error messages for other validation rules
    ]);

    // Retrieve the leave record based on the leave_id
    $staffLeave = Staff_Leave::find($leave_id);

    // Check if the leave record exists
    if (!$staffLeave) {
        return redirect('leaveHistory')->with('error', 'Leave record not found.');
    }

    // Check if the leave record status is 'Pending'
    if ($staffLeave->status !== 'Pending') {
        return redirect('leaveHistory')->with('error', 'Cannot edit leave. Leave status is not Pending.');
    }
    $startDate = Carbon::parse($request->startDate);
    $applyEndDate = Carbon::parse($request->endDate);
    $isEmergencyLeave = $request->leaveType === 'Emergency Leave';

    $minimumStartDate = now()->addDays(4);
 
    if (!$isEmergencyLeave && $startDate->lessThan($minimumStartDate)) {
        $formattedMinimumStartDate = $minimumStartDate->format('Y-m-d');
        
        return redirect()->back()->withErrors([
            'startDate' => "Apply date must be at least 4 days from the current date. Start date: $formattedMinimumStartDate"
        ])->withInput();
    }
    $totalLeave = $applyEndDate->diffInDays($startDate)+1;
    $leaveType = $request->leaveType;  
    $overlappingLeave = Staff_Leave::where('user_id', $user['id'])
    ->where(function ($query) use ($startDate, $applyEndDate) {
        $query->where(function ($q) use ($startDate, $applyEndDate) {
            $q->where('applyStartDate', '>=', $startDate)
                ->where('applyStartDate', '<=', $applyEndDate);
        })->orWhere(function ($q) use ($startDate, $applyEndDate) {
            $q->where('applyEndDate', '>=', $startDate)
                ->where('applyEndDate', '<=', $applyEndDate);
        });
    })
    ->exists();
    if ($overlappingLeave) {
        return redirect()->back()->withErrors([
            'startDate' => 'Leave application overlaps with existing leave records.'
        ])->withInput();
    }
    $leave = Leave::where('leave_type', 'like', $request->leaveType)->first();
    $totalNumber = Leave::where('leave_type', $leaveType)->value('totalNumber');
     
    $leaveBalZero = Staff_Leave::where('leaveBal', 0)
    ->where('leaveType', 'like', $request->leaveType)
    ->where('user_id', $user['id'])
    ->exists();
 
     $leaveBal = max(0, $totalNumber - $totalLeave);     
     if ($startDate->greaterThan($applyEndDate)) {
        return redirect()->back()->withErrors([
            'startDate' => 'Start date must be before the end date.'
        ])->withInput();
    }
    // Check if the leave record is found
    if ($leave) {
        // Check if $leave is an instance of the expected model
        if ($leave instanceof Leave) {
            // Check if leave balance is zero
            if ($leaveBalZero) {
                return redirect()->back()->withErrors([
                    'leaveReason' => "Cannot apply leave for $leaveType. Leave balance is zero."
                ])->withInput();
            }
           
            if ($totalLeave > $leaveBal) {
                return redirect()->back()->withErrors([
                    'endDate' => "Selected end date exceeds available days. Maximum available days: $leaveBal"
                ])->withInput();
            }
            $reason = $request->input('leaveReason');
    // Update the leave record with the new information
    $staffLeave->update([
        'leaveType' => $leaveType,
        'leaveBal' => $leaveBal,
        'reason' => $reason,
        'applyStartDate' => $startDate,
        'applyEndDate' => $applyEndDate,
     ]);
    
    Alert::success('Congratulations', 'Leave updated successfully');
    return redirect('leaveHistory');
}

    }
}}