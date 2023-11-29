<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\medicalClaim;
use App\Models\station;
use App\Models\user;
use App\Models\staff_leave;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use RealRashid\SweetAlert\Facades\Alert;

class medicalClaimController extends Controller
{  
    public function medicalClaims()
    {
        return view('leave.MedicalClaim');
    } 
    private function savePhoto($file)
{
    $name = Str::ulid() . '.jpg';
    Image::make($file)->fit(500, 500)->save(public_path("/admin/img/$name"));
    return $name;
}

public function viewmedicalClaimsStatus()
{
    $users=user::all();

    $medicalClaims = medicalClaim::all();
     $stations = station::all();

    return view('leave.viewMedicalClaim',compact('medicalClaims','users','stations'));
} 

public function approveMedicalClaim($id)
{
    // Retrieve the MedicalClaim model based on the provided $id
    $shift = medicalClaim::find($id);

     $shift->update(['claim_status' => 'Approved']);

    // Redirect back or to a specific route
    Alert::success('Congratulations', 'Medical Claim approved successfully');
    return redirect('viewMediacalClaimStatus');
 }

 public function rejectMedicalClaim($id)
 {
    // Retrieve the MedicalClaim model based on the provided $id
    $shift = medicalClaim::find($id);

     $shift->update(['claim_status' => 'Rejected']);

    // Redirect back or to a specific route
    Alert::success('Congratulations', 'Medical Claim rejected successfully');
    return redirect('viewMediacalClaimStatus');
 }
private function deletePhoto($name)
{
    file::delete(public_path("/admin/img/$name"));
}
    public function uploadMedical(Request $request)
    {
        // Validate the form data
 
        $validator = Validator::make($request->all(), [
            'medicalSlip' => 'required|image|mimes:png,jpg,jpeg',
            'amount' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/', // Validating numeric and up to 2 decimal places
            'claimReason' => 'required|string',
        ]);
        
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
    
        if (DB::table('medical_claim')->count() == 0) {
            $id = 'Med0000001';
        } else {
            $id = DB::table('medical_claim')->orderBy('id', 'desc')->value('id');
            $id = 'Med' . sprintf('%07d', intval(substr($id, 6)) + 1);
         }
        $files = [];

        $file = $request->file('medicalSlip');
        $mime = $file->getMimeType();
         
 
      // Convert the array of file names to a comma-separated string
     $user = session('user');
    $userId = $user['id'];
     // Save other form data to the database
    $medical = new medicalClaim();
    $medical->id = $id;
    $medical->image = $this->savePhoto($request->medicalSlip); // Save as a string
    $medical->claim_status = 'Pending';
    $medical->amount = $request->amount;
    $medical->reason = $request->claimReason;
    $medical->user_id = $userId;
  
    foreach ($files as $filename) {
        $fileContent = file_get_contents(public_path('files') . '/' . $filename);
        $medical->file_content = $fileContent; // Assuming 'file_content' is the BLOB column in your database
    }
    
    $medical->save();
    return redirect()->route('viewLeave');
}
public function claimHistory()
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
        $medicalClaim = medicalClaim::where('user_id', $user['id'])->get();
        
        // The session ID matches, proceed with the medical history view
        return response()->view('leave.MedicalClaimHistory', [ 'medicalClaim'=>$medicalClaim, 'user' => $user, 'sessionId' => $sessionId]);
    } else {
        // If the session ID doesn't match, log the user out and redirect to login
        Session::forget('user');
        return redirect('../login')->with('error', 'Session mismatch, please login again.');
    }
}
}
