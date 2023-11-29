<?php

namespace App\Http\Controllers;
use App\Models\user;

use Illuminate\Http\Request;

class staffController extends Controller
{
    public function index()
    {
        return view('staff.header');
    }
    public function show()
    {
        return view('admin.manageStaff');
    }
    public function index2()
    {
        return view('staff.dailyattendance');
    }
    
    public function staffprofile(){
        // Retrieve the session ID
       $sessionId = session()->getId();
       $station = User::with('station')->get();

       if (!session('user')) {
           return redirect('../login')->with('error', 'Please login to do the further action.');
       }
       // Retrieve customer data from the session
       $user = session('user');
     
       // Check if the session ID matches the customer's session ID
       if ($user['session_id'] == $sessionId) {
        // The session ID matches, proceed with the profile view

        // Assuming you have a 'station' relationship in your User model
        $stationName = User::findOrFail($user['id'])->station->name;

        return response()->view('staff.profileStaff', [
            'user' => $user,
            'sessionId' => $sessionId,
            'stationName' => $stationName,
        ]);
    } else {
        // If the session ID doesn't match, log the user out and redirect to login
        Session::forget('user');
        return redirect('../login')->with('error', 'Session mismatch, please login again.');
    }
}
   }  