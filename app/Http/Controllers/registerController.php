<?php
  namespace App\Http\Controllers;
 use App\Models\customer;
 use App\Models\membership;

  use App\Http\Controllers\Controller;
 use App\Providers\RouteServiceProvider;
 use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Hash;
 use Illuminate\Support\Facades\Validator;
 use Illuminate\Support\Facades\DB;
 use SimpleSoftwareIO\QrCode\Facades\QrCode;
 use BaconQrCode\Renderer\ImageRenderer; 
 use Illuminate\Support\Facades\Mail;
 use App\Mail\RegistrationConfirmation; 
 use BaconQrCode\Renderer\Image\RendererStyle\RendererStyle; 
use BaconQrCode\Writer; 
class RegisterController extends Controller
{
    public function registerindex()
    {
        return view('register');
    }
    
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customer',
            'Password' => 'required|min:8',
            'CPassword' => 'required|same:Password', // Remove extra comma here
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
         }
         
         $membershipCardNumber = $fixedPrefix . $randomSuffix;

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
    $customer->status = 'active';
    $customer->referral_code = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 9);
    $customer->password = Hash::make($request->Password);
    $customer->reward_points = $reward_points;
    $customer->cust_points = 0;
    $customer->chop_quantity = 0;
    $customer->membershipCard = $membershipCardNumber;
 
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
