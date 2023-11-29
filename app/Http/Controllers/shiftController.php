<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\user;
use App\Models\station;
use App\Models\shift;
use RealRashid\SweetAlert\Facades\Alert;
 use Session;
class shiftController extends Controller
{
    public function viewShift()
    {
        if (!session('user')) {
            if (session('customer')) {
                return redirect('login')->with('error', 'Illegitimate Access! You cannot access this page.');
            }
            return redirect('login')->with('error', 'Please login to continue.');
        }
    
        // Check if the user is a manager
        if (isset(session('user')['role']) && session('user')['role'] !== 'Manager') {
            return redirect('login')->with('error', 'Illegitimate Access! You must be a Manager to access this page.');
        }
        $users=user::all();
        $stations=station::all();
        $shifts=shift::all();

        return view('shift.viewShift', compact('users','stations','shifts'));
    }
    public function viewPendingShift()
    {
        if (!session('user')) {
            if (session('customer')) {
                return redirect('login')->with('error', 'Illegitimate Access! You cannot access this page.');
            }
            return redirect('login')->with('error', 'Please login to continue.');
        }
    
        // Check if the user is a manager
        if (isset(session('user')['role']) && session('user')['role'] !== 'Manager') {
            return redirect('login')->with('error', 'Illegitimate Access! You must be a Manager to access this page.');
        }
        $users=user::all();
        $stations=station::all();
        $shifts=shift::all();

        return view('shift.viewPendingShiftStatus', compact('users','stations','shifts'));
    }
    public function approveShift(Request $request, $id)
    {
        // Retrieve the Shift model based on the provided $id
        $shift = Shift::find($id);

        // Perform approval logic, e.g., update the ShiftChangeStatus
        $shift->update(['ShiftChangeStatus' => 'Approved']);

        // Redirect back or to a specific route
        return redirect()->back()->with('success', 'Shift approved successfully');
    }

    public function rejectShift(Request $request, $id)
    {
        // Retrieve the Shift model based on the provided $id
        $shift = Shift::find($id);

        // Perform rejection logic, e.g., update the ShiftChangeStatus
        $shift->update(['ShiftChangeStatus' => 'Rejected']);

        // Redirect back or to a specific route
        return redirect()->back()->with('success', 'Shift rejected successfully');
    }
    public function applyShiftReq(Request $request)
    {
        // Validate the request data
        $request->validate([
            'station_id' => 'required|exists:station,id',
            'staff_id' => 'required|exists:user,id',
            'shift_type' => 'required|in:morning,afternoon,night',
        ]);
 
        
         $user = User::find($request->staff_id);
          $shift = shift::find($user->shift_id);
          
             // Update the existing shift
            $shift->ShiftType =$request->shift_type;
             $shift->save();
    
        // Redirect back with a success message
        Alert::success('Congratulations', 'Shift Updated Successfully');
        return redirect('/viewShift');
     }
    
    
 
    public function applyShift()
    {
        $station = station::all();         

        return view('shift.applyShift',['stations'=>$station]);
    }

    public function editShift()
    {
        return view('shift.editShift');
    }
    public function rescheduleViewShift()
    {
        return view('shift.staffViewShift');
    }
} 
