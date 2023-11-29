<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
namespace App\Http\Controllers;

 use App\Models\customer;
 use App\Models\user;
use Illuminate\Support\Facades\Auth;
 use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
 use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Support\Facades\RateLimiter as RateLimiterFacade;
 use Illuminate\Support\Facades\Session;
 use Illuminate\Auth\Events\Lockout;
 use Illuminate\Support\Facades\Password; 
class loginController extends Controller
{    use AuthenticatesUsers, ThrottlesLogins;

    public function registerindex()
    {
        return view('register');
    }
 
public function postLogin(Request $request)
{
    
    $email = $request->email;
    $password = $request->password;

    $maxLoginAttempts = 5; // Maximum number of login attempts
    $lockoutTime = 30; // Lockout time in minutes
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ], [
        'email.required' => 'The email field is required.',
        'email.email' => 'Please enter a valid email address.',
        'password.required' => 'The password field is required.',
    ]);

    // Check if the user is already locked out
    if ($this->hasTooManyLoginAttempts($request)) {
        $this->fireLockoutEvent($request);
        return $this->sendLockoutResponse($request);
    }
    // Check if the user is already locked out
    if ($this->hasTooManyLoginAttempts($request)) {
        $this->fireLockoutEvent($request);
        return $this->sendLockoutResponse($request);
    }

    $customer = Customer::where('email', '=', $email)->first();
    $user = User::where('email', $email)->first();

    // Check if the login attempt is successful for customers
    if ($customer && Hash::check($password, $customer->password)) {
        $this->clearLoginAttempts($request);
        if ($customer->status === 'inactive') {
            // Add a custom error message to the session
            session()->flash('error', 'Your account is inactive.');
            return redirect()->back()->withInput();
        }
        // Store customer data in the session
        session(['customer' => [
            'id' => $customer->id,
            'name' => $customer->name,
            'email' => $customer->email,
            'membership_id' => $customer->membership_id,
            'membershipCard' => $customer->membershipCard,
            'referral_code' => $customer->referral_code,
            'cust_rank' => $customer->cust_rank,
            'reward_points' => $customer->reward_points,
            'session_id' => session()->getId(), // Store the session ID
        ]]);

        // Redirect to the profile page
        return redirect()->route('profile')->with('success', 'Welcome, ' . $customer->name . '!');
    } elseif ($user && Hash::check($password, $user->password)) {
        $this->clearLoginAttempts($request);
        if ($user->status === 'Resign') {
            // Add a custom error message to the session
            session()->flash('error', 'Your account is inactive.');
            return redirect()->back()->withInput();
        }
        // Store user data in the session
        session(['user' => [
            'id' => $user->id,
            'name' => $user->name,
            'role' => $user->role,
           'gender' => $user->gender, 
           'email'=> $user->email,
           'identityCard'=>$user->identityCard,
            'shift_id'=> $user->shift_id,
           'salary_id'=> $user->salary_id,
           'station_id'=> $user->station_id,
           'session_id' => session()->getId(),
        ]]);

        // Redirect based on user role
        if ($user->role === 'Staff') {
            $request->session()->put('session_role', 'Staff');
            return redirect()->route('manageStaff')->with('success', 'Welcome, Staff!');
        } elseif ($user->role === 'Manager') {
            $request->session()->put('session_role', 'Manager');
            return redirect()->route('dashApply')->with('success', 'Welcome, Manager!');
        }
    } else{
        // Increment the login attempts
        $this->incrementLoginAttempts($request);
    
        // Check if the user should be locked out
        if ($this->hasTooManyLoginAttempts($request)) {
            // Redirect to the forget password page
            return redirect()->route('forgetPassword')->with('error', 'Too many login attempts. Please reset your password.');
        }
    
        // Add a custom error message to the session
        session()->flash('error', 'Invalid email or password.');
    
        // Check if the user reached 3 login attempts for password reset
        if ($this->hasTooManyLoginAttempts($request)) {
            $user = User::where('email', $request->email)->first();
            if ($user) {
                // Generate a password reset token and send the reset link
                $token = Password::getRepository()->create($user);
                $this->sendResetEmail($user->email, $token);
                session()->flash('info', 'Too many login attempts. Password reset link sent to your email.');
            }
        }
    
        return redirect()->back()->withInput();
    }
}
protected function hasTooManyLoginAttempts(Request $request)
{
    return $this->limiter()->tooManyAttempts(
        $this->throttleKey($request), $this->maxAttempts(), $this->decayMinutes()
    );
}

protected function incrementLoginAttempts(Request $request)
{
    $this->limiter()->hit(
        $this->throttleKey($request), $this->lockoutTime() * 60
    );
}

protected function clearLoginAttempts(Request $request)
{
    $this->limiter()->clear($this->throttleKey($request));
}

protected function sendLockoutResponse(Request $request)
{
    $seconds = $this->limiter()->availableIn($this->throttleKey($request));

    $minutes = ceil($seconds / 60);

    return redirect()->back()->withInput()->withErrors([
        'message' => "Too many login attempts. Please try again in {$minutes} minutes.",
    ]);
}

protected function lockoutTime()
{
    return 5; // Adjust the lockout time in minutes as needed
}

    public function logout() {
    if (Session::has('user')) {
        Session::forget('user');
    }else if(Session::has('customer')) {
        Session::forget('customer');
    }
    Session::flush();
    
    return redirect('login')->with('success', 'Logout successfully!');
    } 
 

    public function dashboard()
    {
 
      if(Auth::check()){
        return view('dashboard');
      }
      return redirect()->route('login')->with('success', 'to login .');
    }
    private function sendResetEmail($email, $token)
    {
    //Retrieve the user from the database
    $user = DB::table('users')->where('email', $email)->select('firstname', 'email')->first();
    //Generate, the password reset link. The token generated is embedded in the link
    $link = config('base_url') . 'password/reset/' . $token . '?email=' . urlencode($user->email);
    
        try {
        //Here send the link with CURL with an external email API 
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customer|unique:user',
            'Password' =>  ['required', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'],
            'Confirm Password' => 'required|same:Password', // Remove extra comma here
            'Rcode' => 'nullable|string|max:9',
        ]);
        if ($validator->fails()) {

            if ($request->CPassword && $request->Password != $request->CPassword) {
                return redirect('/register')
                                ->withErrors(array_merge($validator->errors()->toArray(), ['CPassword' => 'Confirm password must match password field.']))
                                ->withInput();
            }
            return redirect('/register')
                            ->withErrors($validator)
                            ->withInput(); 
        } else {

            if ($request->CPassword && $request->Password != $request->CPassword) {
                return redirect('/register')
                                ->withErrors(['CPassword' => 'Confirm password must match password field.'])
                                ->withInput();
            }
        }  

        if (DB::table('customer')->count() == 0) {
            $id = 'Cus0000001';
        } else {
            $id = DB::table('customer')->orderBy('id', 'desc')->value('id');
            $id = 'Cus' . sprintf('%07d', intval(substr($id, 6)) + 1);
         }
         $fixedPrefix = '6018';
         $randomSuffix = '';
         
         for ($i = 0; $i < 12; $i++) {
             $randomSuffix .= rand(0, 9);
         
             if (($i + 1) % 4 === 0 && $i !== 11) {
                 $randomSuffix .= '-';
             }
         }
         
         $membershipCard = $fixedPrefix . '-' . $randomSuffix;

        $referralCode = $request->Rcode;
        $affectedRows = Customer::where('referral_code', $referralCode)
            ->update(['cust_points' => DB::raw('cust_points ')]);
        
        if ($affectedRows> 0) {
            // Fetch the customer with the referral code
            $referringCustomer = Customer::where('referral_code', $referralCode)->first();
        
            // Update the cust_points attribute
            $referringCustomer->cust_points += 100;
        
            // Save the changes to the customer model
            $referringCustomer->save();
        }  
        
        $reward_points = 0; // Assuming the customer starts with 0 points

        // Find the appropriate membership rank based on reward_points
        $membershipRank = DB::table('membership')
        ->where('required_points', '<=', $reward_points)
        ->orderBy('required_points', 'desc')
        ->first();

         
       
    // Create a new customer instance
    $customer = new Customer;
    $customer->id = $id;
    $customer->name = $request->fullname;
    $customer->email = $request->email;
    $customer->status = 'Active';
    $customer->referral_code = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 9);
    $customer->password = Hash::make($request->Password);
    $customer->reward_points = $reward_points;
    $customer->cust_points = 0;
    $customer->chop_quantity = 0;
    $customer->membershipCard = $membershipCard;
    $customer->token = 0;
     if ($membershipRank) {
        // If a valid membership rank is found, use its details
        $customer->cust_rank = $membershipRank->rank_name;
        $customer->membership_id = $membershipRank->id; // Use the valid membership_id
    } else {
        // Handle the case where no matching membership rank is found
        // Set default values or a default membership_id based on your requirements.
        $customer->cust_rank = 'Bronze'; // Set a default rank
        $customer->membership_id = 'DefaultMembershipId'; // Set a default membership_id
    }
    // Save the customer data
    $customer->save(); 
    
        return redirect()->route('login')->with('success', 'Your account has been created.');
    }
    
}
