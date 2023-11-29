<?php

namespace App\Http\Controllers;

use App\Models\training;
 use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class trainingController extends Controller
{
  
    public function viewStock()
    { if (!session('user')) {
        if (session('customer')) {
            return redirect('login')->with('error', 'Illegitimate Access! You cannot access this page.');
        }
        return redirect('login')->with('error', 'Please login to continue.');
    }

    // Check if the user is a manager
    if (isset(session('user')['role']) && session('user')['role'] !== 'Manager') {
        return redirect('login')->with('error', 'Illegitimate Access! You must be a Manager to access this page.');
    }
        $trainings = training::all();
     
        return view('training.viewTraining', compact('trainings'));
    }
    

    public function create()
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
        $trainings = training::all();

        // Return the view for creating a new training
        return view('training.addTraining', compact('trainings'));
    }

    public function store(Request $request)
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
        $request->validate([
            'training_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date|date_format:Y-m-d H:i|after_or_equal:'.now()->format('Y-m-d 08:00').'|before_or_equal:'.now()->format('Y-m-d 18:00'),
            'end_date' => 'required|date|date_format:Y-m-d H:i|after_or_equal:start_date|before_or_equal:'.now()->addHours(10)->format('Y-m-d 18:00'),
            'description' => 'nullable|string',
        ], [
            'start_date.after_or_equal' => 'The training start time must be equal to or after 8:00 AM and before 6:00 PM.',
            'end_date.before_or_equal' => 'The training end time must be equal to or before 6:00 PM.',
        ]);    
       
        $latestId = DB::table('training')->orderBy('id', 'desc')->value('id');
    
        if ($latestId) {
            $sequence = intval(substr($latestId, 2)) + 1;
            $id = 'TG' . str_pad($sequence, 7, '0', STR_PAD_LEFT);
        } else {
            $id = 'TG0000001';
        }
        // $user = session('user');
        $userId = session('user')['id'];
                 // Create a new training record in the database
        $training = new training();
        $training->id = $id;
        $training->training_name = $request->input('training_name');
        $training->description = $request->input('description');
        $training->start_date = Carbon::createFromFormat('Y-m-d\TH:i', $request->start_date);
        $training->end_date = Carbon::createFromFormat('Y-m-d\TH:i', $request->end_date);
        $training->status = 'Active';
        $training->location = $request->input('location');
        $training->user_id = $userId;

        $training->save();
        Alert::success('Congratulations', 'Training created successfully');
       
        return redirect('training');
       
    }
    

    public function edit($id)
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
         $training = Training::find($id);

        // Return the view for editing the training
        return view('training.editTraining', compact('training'));
    }
// TrainingController.php

public function show($id)
{
    // Assuming you have a model named 'Training' for your training table
    $training = Training::find($id);

    return view('training.trainingDetail', compact('training'));
}

    public function update(Request $request, $id)
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
        // Retrieve the training record by its ID
        $training = Training::find($id);

        $request->validate([
            'training_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date|date_format:Y-m-d H:i|after_or_equal:'.now()->format('Y-m-d 08:00').'|before_or_equal:'.now()->format('Y-m-d 18:00'),
            'end_date' => 'required|date|date_format:Y-m-d H:i|after_or_equal:start_date|before_or_equal:'.now()->addHours(10)->format('Y-m-d 18:00'),
            'description' => 'nullable|string',
        ], [
            'start_date.after_or_equal' => 'The training start time must be equal to or after 8:00 AM and before 6:00 PM.',
            'end_date.before_or_equal' => 'The training end time must be equal to or before 6:00 PM.',
        ]);    
        $userId = session('user')['id'];

        // Update the training record with the new data
        // $training->update($validatedData);
        $training->training_name = $request->get('training_name');
        $training->description = $request->get('description');
        $training->start_date = $request->get('start_date');
        $training->end_date = $request->get('end_date');
        $training->status = $request->get('start_date');
        $training->status = 'Active';
        $training->location = $request->get('location');
        $training->user_id = $userId ;
 
        $training->save();

        // Redirect back to the form with a success message
        return redirect()->route('trainings.index');
      }

    public function destroy($id)
    {
        // Retrieve the training record by its ID and delete it
        $training = Training::find($id);
        $training->delete();
    Alert::success('Success', 'Training deleted successfully');
        // Redirect to the viewstock page with a success message
        return redirect()->route('trainings.index');
    }
    public function EditTraining()
    {
         $trainings = Training::all();

        // Pass the retrieved data to the view
        return view('training.editTraining', ['trainings' => $trainings]);
    }
    // public function viewTraining()
    // {
    //     return view('training.viewTraining');
         
    // }
    // public function trainingDetail()
    // {
    //     return view('training.trainingDetail');
         
    // }
}
