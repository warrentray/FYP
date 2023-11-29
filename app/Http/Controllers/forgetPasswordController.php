<?php

namespace App\Http\Controllers;

use Illuminate\Console\View\Components\Alert;
use Illuminate\Http\Request;
use App\Models\customer;
use App\Models\user;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Session;
class forgetPasswordController extends Controller
{
    public function index()
    {
        // return view('forgetPassword');
        return view('resetPassword');
    }

    
    public function index2()
    {
        // return view('forgetPassword');
        return view('forgetPassword');
    }
private function sendVerificationEmail($email, $token, $id)
{
    $details = [
        'title' => 'Reset Password Verification Link',
        'body' => url('/resetPassword?token=' . $token . '&id=' . $id),
    ];

    Mail::to($email)->send(new \App\Mail\VerificationCodeMail($details));
}

    public function verifyEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255',
        ]);

        $email = $request->input('email');
        $customer = Customer::where('email', $email)->first();
        $user = User::where('email', $email)->first();

        if ($customer) {
            $token = $this->generateVerificationToken();
            $customer->token = $token;
            $customer->save();
            $this->sendVerificationEmail($customer->email, $token, $customer->id);
            $request->session()->put('reset_data', ['email' => $customer->email, 'id' => $customer->id]);

 
            return view('validateEmailToken', ['email' => $customer->email, 'id' => $customer->id]);
        } elseif ($user) {
            $token = $this->generateVerificationToken();
            $user->token = $token;
            $user->save();
            $this->sendVerificationEmail($user->email, $token, $user->id);

            $request->session()->put('reset_data', ['email' => $customer->email, 'id' => $customer->id]);

            return view('validateEmailToken', ['email' => $user->email, 'id' => $user->id]);
        } else {
            return redirect()->route('forgetPassword')->with('error', 'User not found.');
        }
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
        ]);

        $customer = Customer::find($request->id);
        $user = User::find($request->id);

        if ($customer && $this->isValidToken($request->token, $customer->token)) {
            $request->session()->put('reset_data', ['email' => $customer->email, 'id' => $customer->id]);

            return view('resetPassword', ['email' => $customer->email, 'id' => $customer->id]);
        } elseif ($user && $this->isValidToken($request->token, $user->token)) {
            $request->session()->put('reset_data', ['email' => $customer->email, 'id' => $customer->id]);

            return view('resetPassword', ['email' => $user->email, 'id' => $user->id]);
        } else {
            return redirect()->route('login')->with('error', 'Invalid token or user not found.');
        }
    }

    public function reset(Request $request)
    {
        
        $request->validate([
            'Password' => ['required', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'],
            'CPassword' => 'required|same:Password',
        ], [
            'Password.required' => 'The password field is required.',
            'Password.regex' => 'The password must be at least 8 characters long and contain at least one lowercase letter, one uppercase letter, one number, and one special character (@$!%*?&).',
            'CPassword.required' => 'The confirm password field is required.',
            'CPassword.same' => 'The password and confirm password must match.',
        ]);
 
        $resetData = $request->session()->get('reset_data');
    $customer = Customer::find($resetData['id']);
    $user = User::find($resetData['id']);
     if ($customer && $this->isValidToken($customer->token, $customer->token)) {
        $customer->password = Hash::make($request->Password);
        $customer->save();
    
        return redirect()->route('login')->with('success', 'Password Reset Successfully.');
    } elseif ($user && $this->isValidToken($user->token, $user->token)) {
        $user->password = Hash::make($request->Password);
        $user->save();
        
        return redirect()->route('login')->with('success', 'Password Reset Successfully.');
    } else {
        return redirect()->route('login')->with('error', 'User not found or invalid token.');
    }
    }
     

    private function generateVerificationToken()
    {
        return bin2hex(random_bytes(32));
    }

  
    

    private function isValidToken($inputToken, $savedToken)
    {
        // Check if $savedToken is null or not a string
        if (!is_string($savedToken) || $savedToken === null) {
            return false;
        }
    
        return hash_equals($savedToken, $inputToken);
    }
    
    
}