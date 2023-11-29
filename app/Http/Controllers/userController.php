<?php

namespace App\Http\Controllers;

 use App\Models\customer;
use App\Models\membership;
use App\Models\user;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
 use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
 use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
 use Session;

 use RealRashid\SweetAlert\Facades\Alert;

class userController extends Controller
{
    public function index()
    {
        return view('login');
    }
//     public function profile()
// {
    //Check if the user is logged in
    // if (!session('customer_id')) {
    //     return redirect('login')->withErrors(['error' => 'Please login to continue.']);
    // }

    // // Check the user's role in the first database connection (database1)
    // $user1 = DB::connection('PetrolStationManagementSystem')->table('user')->where('id', session('customer_id'))->first();
    // if (!$user1 || ($user1->role !== 'Staff' && $user1->role !== 'Manager')) {
    //     return redirect('login')->withErrors(['error' => 'Illegitimate Access! You must be a Staff or Manager to access this page.']);
    // }

    // // If you need to check the user's role in the second database connection (database2),
    // // you can use a similar approach:
    // $user2 = DB::connection('PetrolStationManagementSystem')->table('user')->where('id', session('customer_id'))->first();
    // if (!$user2 || ($user2->role !== 'Staff' && $user2->role !== 'Manager')) {
    //     return redirect('login')->withErrors(['error' => 'Illegitimate Access! You must be a Staff or Manager to access this page.']);
    // }

    
    // If both checks pass, you can proceed with the view
//     $customer_Id = session('customer_id');
//     return view('resetPassword', ['customer_id' => $customer_Id]);
// }
public function profile() {
    // Retrieve the session ID
    $sessionId = session()->getId(); 
    if (!session('customer')) {
        return redirect('../login')->with('error', 'Please login to do the further action.');
    }
    // Retrieve customer data from the session
    $customer = session('customer');
  
    // Check if the session ID matches the customer's session ID
    if ($customer['session_id'] == $sessionId) {
        // The session ID matches, proceed with the profile view
        return response()->view('profile', ['customer' => $customer, 'sessionId' => $sessionId]);
    } else {
        // If the session ID doesn't match, log the user out and redirect to login
        Session::forget('customer');
        return redirect('../login')->with('error', 'Session mismatch, please login again.');
    }
}
 
   
    public function registerindex()
    {
        return view('register');
    }
    
    
    public function create() {
        session_start();

        if($_SESSION['role'] = 'Staff') {
        return view('shift.applyShift');
    }else if ($_SESSION['role'] = 'Manager') {
        return view('shift.applyShift');

    }else{        
        return view('register');
    }
}
 
// after validate
// session_start();
// session()->put('session_id', $user->id);
// session()->put('session_role', $user->role);
 
}
