<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Station;
use App\Models\Attendance;
use App\Models\shift;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;  

class AttendanceController extends Controller
{
    
    public function signin()
    {
        $users = User::all();
        $station = Station::first(); 

         $userAlreadySignedIn = $this->checkIfUserAlreadySignedIn();
         $userAlreadySignedOut = $this->checkIfUserAlreadySignedOut();

        return view('staff.dailyattendance', compact('users', 'station', 'userAlreadySignedIn','userAlreadySignedOut'));
    }
   // In the controller method
   public function historyAttendance()
   {
       $userId = session('user')['id'];
       $user = attendance::where('user_id', $userId)->get(); // Note: Use get() to get all records
   
       // Check if $user is empty
       if ($user->isEmpty()) {
           // Handle the case when $user is empty, e.g., redirect to an error page
           return redirect()->route('error.page')->with('error', 'User attendance records not found.');
       }
   
       $shift = user::find($userId)->shift;
       $loginTime = now();
   
       if ($shift->ShiftType === 'morning') {
           $loginTime->setTime(6, 0, 0); // Morning shift login at 6 am
       } elseif ($shift->ShiftType === 'afternoon') {
           $loginTime->setTime(16, 0, 0); // Afternoon shift login at 4 pm
       } elseif ($shift->ShiftType === 'night') {
           $loginTime->setTime(0, 0, 0); // Night shift login at 12 am
       }
   
       $onTimeCount = 0;
       $lateCount = 0;
   
       foreach ($user as $attendance) {
           // Check if $attendance is an array and if 'sign_in_time' is set
           if (isset($attendance['sign_in_time'])) {
               $isLate = strtotime($attendance['sign_in_time']) > $loginTime->timestamp;
   
               if ($isLate) {
                   $lateCount++;
               } else {
                   $onTimeCount++;
               }
           }
       }
   
       $totalAttendance = $user->count();
   
       $onTimePercentage = ($onTimeCount / $totalAttendance) * 100;
       $latePercentage = ($lateCount / $totalAttendance) * 100;
   
       return view('staff.historyAttendance', compact('onTimePercentage','user', 'latePercentage', 'onTimeCount', 'lateCount', 'totalAttendance'));
   }
   
    
    public function storeAttendance(Request $request) 
    {
        // Get the user details from the session
        $userId = session('user')['id']; 
             $todaySignIn = Attendance::where('user_id', $userId)
                ->whereDate('sign_in_time', Carbon::today())
                ->exists();
    
            if ($todaySignIn) {
                // If already signed in today, only allow sign out
                $this->signOut($userId);
                return redirect('/dailyattendance')->with('toast_success', 'Attendance sign out ' . now()->format('H:i:s'));
            }
    
            // If not signed in today, proceed with sign in
            $this->staffsignin($userId);
            return redirect('/dailyattendance')->with('toast_success', 'Attendance sign in ' . now()->format('H:i:s'));
        }
        protected function checkIfUserAlreadySignedIn()
        {
            $userId = session('user')['id'];
            $today = now()->toDateString();
    
            // Check if the user has already signed in today
            return Attendance::where('user_id', $userId)
                ->whereDate('sign_in_time', $today)
                ->exists();
        }
        protected function checkIfUserAlreadySignedOut()
        {
            $userId = session('user')['id'];
            $today = now()->toDateString();
    
            // Check if the user has already signed in today
            return Attendance::where('user_id', $userId)
                ->whereDate('sign_out_time', $today)
                ->exists();
        }
        protected function signOut($userId)
        {
            // Find the latest attendance record for the user and update the sign_out_time
            $latestAttendance = Attendance::where('user_id', $userId)
                ->latest('sign_in_time')
                ->first();
    
            if ($latestAttendance) {
                $latestAttendance->update(['sign_out_time' => now()]);
            }
            Alert::success('Congratulations', 'Attendance sign out' . date('H:i:s'));       

        }  protected function staffsignin($userId)
        {
            $latestattendanceId = DB::table('attendance')->latest('id')->value('id');
              $user=user::find($userId);

            $id = ($latestattendanceId) ? 'A' . sprintf('%08d', intval(substr($latestattendanceId, 7)) + 1) : 'A00000001';
            
 
            $shiftType = $user->shift->ShiftType; // Assuming you have a 'shiftType' column in your users table
              // Set login time based on shift type
              $shiftType = strtolower($shiftType); // Convert to lowercase
            $loginTime = now();
            if ($shiftType === 'morning') {
                $loginTime->setTime(6, 0, 0); // Morning shift login at 6 am
            } elseif ($shiftType === 'afternoon') {
                $loginTime->setTime(16, 0, 0); // Afternoon shift login at 4 pm
            } elseif ($shiftType === 'night') {
                $loginTime->setTime(0, 0, 0); // Night shift login at 12 am
            }
        
            // Check for lateness
            $allowedGracePeriod = 15; // Assuming a 15-minute grace period
            if (now()->diffInMinutes($loginTime) > $allowedGracePeriod) {
                Alert::warning('Warning', 'You are late!'); // Adjust the message as needed
            }
            $attendance = new Attendance();
            $attendance->id = $id;
            $attendance->sign_in_time = now();
            $attendance->sign_out_time = null; // Assuming you want to store null for sign_out_time initially
            $attendance->user_id = $userId; // Assuming your Attendance model has 'user_id' attribute
            $attendance->save();
    
            Alert::success('Congratulations', 'Attendance sign in '. date('H:i:s'));       
         }
       
    } 