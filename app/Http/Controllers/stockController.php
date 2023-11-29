<?php

namespace App\Http\Controllers;

 use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\petrol;
use App\Models\station;
use App\Models\delivery;
use App\Models\stock;

use Carbon\Carbon; // For date and time handling

use RealRashid\SweetAlert\Facades\Alert;
class stockController extends Controller
{
    
    public function petrolDetail()
    {
        $petrols = petrol::all();
        $station=station::all();
        return view('stock.petrolDetail', compact('petrols','station'));
    }
    public function editpetrol($id)  
    {  
        
        $petrols = petrol::find($id);  

      return view('stock.editPetrol', compact('petrols'));  
    }  


    public function updatePetrol(Request $request, $id)
    {
        // Retrieve the petrol record by its ID
        $petrolRequest = petrol::find($id);
    
        if (!$petrolRequest) {
            // Handle the case where the record is not found
            return redirect()->route('editPetrol', ['id' => $id])->with('fail', 'Petrol not found');
        }
    
       
            // Form was submitted, continue with validation and saving to the database
            $validator = Validator::make($request->all(), [
                'fuelname' => 'required|string|unique:petrol,petrol_name,' . $id,
                'petrol' => 'required|in:Petrol,Diesel',
                'price' => [
                    'required',
                    'numeric',
                    'regex:/^\d+(\.\d{1,2})?$/',
                ],
            ], [
                'fuelname.unique' => 'The fuel name already exists in the database.',
                'price.regex' => 'The price must have up to two decimal places.',
            ]);
    
            if ($validator->fails()) {
                return redirect()->route('editPetrol', ['id' => $id])
                    ->withErrors($validator)
                    ->withInput();
            }
    
            // Update the petrol record with the new data
            $petrolRequest->petrol_name = strtoupper($request->get('fuelname'));
            $petrolRequest->petrol_type = $request->get('petrol');
            $petrolRequest->price_per_liter = $request->get('price');
            $petrolRequest->save();

            Alert::success('success','Petrol information updated successfully');
            // Redirect back to the form with a success message
            return redirect()->route('petrolDetail');
    
    }
         public function destroy($id)
        {
         $petrols = petrol::find($id)->delete();
        Alert::success('success','Petrol deleted successfully');

         return redirect()->route('petrolDetail');
         }
         public function addpetrol()
         {
        $station=station::all();
        $stock=stock::all();
        $petrolTypes = ['Petrol' => 'Petrol', 'Diesel' => 'Diesel'];

        return view('stock.addpetrol', compact('petrolTypes','station','stock'));
         
         }
         public function petrolRequest(Request $request){
            if ($request->isMethod('post')) {
                if (DB::table('petrol')->count() == 0) {
                    $id = 'PT0000001';
                } else {
                    $id = DB::table('petrol')->orderBy('id', 'desc')->value('id');
                    $id = 'PT' . sprintf('%07d', intval(substr($id, 6)) + 1);
                 }
                 if (DB::table('stock')->count() == 0) {
                    $stockid = 'SK000001';
                    $stocknumber=1;
                } else {
                    $stockid = DB::table('petrol')->orderBy('id', 'desc')->value('id');
                    $stockid = 'SK' . sprintf('%06d', intval(substr($stockid, 5)) + 1);
                    $stocknumber = DB::table('petrol')->orderBy('tank_number', 'desc')->value('tank_number');
                    $stocknumber += 1 ;
                 }

                // Form was submitted, continue with validation and saving to the database
                $validator = Validator::make($request->all(), [
                    'fuelname' => 'required|string|',
                    'petrol' => 'required|in:Petrol,Diesel',
                    'price' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
 
                ], [
                     'price.regex' => 'The price must have up to two decimal places.',
                ]);
        
                if ($validator->fails()) {
                    return redirect()->route('addPetrol')
                        ->withErrors($validator)
                        ->withInput();
                }
                 $stationId = Station::find($request->stationName);
                  
                 $stock=new stock();
                $stock->id=$stockid;
                $stock->tank_number= $stocknumber;
                $stock->tank_capability= $request->tankCapability;
                $stock->tank_type= $request->petrol;
                $stock->tank_quantity= 0; 
                $stock->station_id= $stationId->id ; 
                $stock->save();

                // Save the data to the database (in uppercase)
                $petrolRequest = new petrol();
                $petrolRequest->id = $id;
                $petrolRequest->petrol_name = strtoupper($request->fuelname);
                $petrolRequest->petrol_type = $request->petrol;
                $petrolRequest->price_per_liter = $request->price;
                $petrolRequest->stock_id = $stockid;
                $petrolRequest->save();
               
                // Redirect back to the form with a success message
                return redirect()->route('petrolDetail');
            }
            return redirect()->route('addPetrol')->with('fail', 'Petrol request decline ');
        }
        public function viewStock()
        {
            $stations = station::all();
            $deliverys = delivery::all();
        
            return view('stock.viewStock', compact('stations', 'deliverys'));
        }
// Create a new method in your DeliveryController
public function getDeliveries(Request $request) {
    $stationName = $request->input('stationName');
    $deliveries = Delivery::where('station_name', $stationName)->get();
 
    return response()->json($deliveries);
 }
 
          private function generateDeliveryNoteId()
          {
              $latestId = DB::table('delivery')->orderBy('id', 'desc')->value('id');
          
              if ($latestId) {
                  $sequence = intval(substr($latestId, 2)) + 1;
                  $id = 'DY' . str_pad($sequence, 7, '0', STR_PAD_LEFT);
              } else {
                  $id = 'DY0000001';
              }
          
              return $id;
          }
 
          public function getDeliveryDetails($deliveryId)
          {
              // Retrieve the delivery details from the database based on the $deliveryId
              $delivery = Delivery::find($deliveryId);
          
              // Check if the delivery exists
              if (!$delivery) {
                  // Handle the case where the delivery is not found
                  return redirect()->route('viewStock')->with('error', 'Delivery not found');
              }
          
              // Pass the $delivery data to the view
              return view('stock.deliveryDetails', compact('delivery'));
          }
          

    public function checkLowStock()
    {
    // Retrieve stocks with quantity <= 5000
    $lowStocks = stock::where('tank_quantity', '<=', 5000)->get();
  
    foreach ($lowStocks as $stock) {
        $existingDeliveryNote = delivery::where('stock_id', $stock->id)->first();
    if ($existingDeliveryNote) {
        $deliveryNote = new Delivery();
        $deliveryNote->date = now()->addDay(); // Set the date to the next day
        $deliveryNote->time = now()->addHours(4); // Set the time to now + 4 hours

        // Calculate the quality based on tank_capacity and tank_quantity
        $tankCapacity = $stock->tank_capability;
        $tankQuantity = $stock->tank_quantity;
        $deliveryNote->quality = ($tankCapacity - $tankQuantity) * 0.7;

        // Other properties
        $deliveryNote->tank_number = $stock->tank_number;
        $deliveryNote->petrol_type = $stock->tank_type;
        $deliveryNote->status = 'Pending';
  
        $deliveryNote->user_id = 'S0000001'; // You can set the user ID as needed
        $deliveryNote->stock_id = $stock->id;

        // Generate a unique ID for the delivery note
        $deliveryNote->id = $this->generateDeliveryNoteId();

        // Save the delivery note
        $deliveryNote->save();
         }
    }   
    // Optionally, you can send notifications here.
}
         public function index4()
         {
              return view('stock.editPetrol');
         
        }
          public function requestStock()
         {
           
            $delivery = Delivery::all();  // Adjust this line to fetch the desired delivery
            $stock = stock::all();  // Adjust this line to fetch the desired delivery

             return view('stock.reqStock', compact('delivery','stock'));
          }          
          public function requestStockSubmit(Request $request)
            {
             // Validate the form data
             $validatedData = $request->validate([
                 'tankNumber' => 'required',
                 'tankType' => 'required|exists:tank_types,name', // Assuming 'tank_types' is the table that contains tank types
                 'quantity' => 'required|numeric|min:0',
             ]);
     
             // Retrieve the delivery ID from the session
             $deliveryId = $request->session()->get('deliveryId');
     
             // Get delivery data based on the delivery ID
             $delivery = Delivery::find($deliveryId);
     
             // If the delivery is not found or there's no delivery ID in the session, handle it accordingly
             if (!$delivery || !$deliveryId) {
                 return redirect()->route('viewStock')->with('error', 'Invalid or missing delivery ID');
             }
     
             // Get stock data based on the selected tank number
             $stock = Stock::where('tank_number', $validatedData['tankNumber'])->first();
     
             // If the stock is not found, handle it accordingly
             if (!$stock) {
                 return redirect()->route('viewStock')->with('error', 'Stock not found for the selected tank number');
             }
     
             // Compare tank capacity with quantity
             if ($stock->tank_capability < $validatedData['quantity']) {
                 return redirect()->route('requestStockForm')->with('error', 'Quantity exceeds tank capacity');
             }
     
              $stock->tank_quantity += $validatedData['quantity'];
             $stock->save(); 
          }

          public function updateStock(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'stockin' => 'required|numeric|min:0',
        ]);

        // Find the stock by ID
        $stock = Stock::find($id);
        $delivery = Delivery::where('stock_id', $stock->id)->first();
         if (!$stock) {
            // Handle the case where the stock is not found
            return redirect()->back()->with('error', 'Stock not found');
        }
        $newQuantity = $stock->tank_quantity + $request->input('stockin');
         // Validate against tank capability
         if ($delivery && $request->input('stockin') > $delivery->quality) {
            // Handle the case where stockin quantity is more than the delivery note quantity
            Alert::error('Oops','Stock quantity more than the quantity delivery note pls refer delivery note');
            return redirect()->route('requestStock');
        }
        
        // Update the stock quantity
        $stock->tank_quantity = $newQuantity;
         $stock->save();
         if ($newQuantity > $stock->tank_capability) {
            Alert::error('Oops','Stock quantity exceeds tank capability');
            return redirect()->route('requestStock');
         }
         if ($delivery) {
            $this->updatedDeliveries[] = $delivery->id;
        }
        if ($delivery && !$request->session()->has('updatedDeliveries.' . $delivery->id)) {
            $request->session()->put('updatedDeliveries.' . $delivery->id, true);
    
            Alert::success('success', 'Stock quantity updated successfully');
        }
 
        return redirect()->route('requestStock');
      }
      protected $updatedDeliveries = [];

    public function index6()
    {
        return view('stock.editStock');
         
    }
    public function infoStock($deliveryId)
    {     $stations = Station::all();
         $delivery = Delivery::with('stock.station')->where('id', $deliveryId)->first();
    
         if (!$delivery) {
            Alert::success('error', 'Delivery not found');
            return redirect()->route('viewStock');
        }
    
      
 
        if (!$delivery) {
            // Handle the case where the delivery is not found
            return response()->json(['error' => 'Delivery not found'], 404);
        }
    
        if ($delivery->stock && $delivery->stock->station) {
            $stationAddress = $delivery->stock->station->address;
            
           
        }  
        if ($delivery->stock && $delivery->stock->station) {
            $fuelname = $delivery->stock->fuelname; 
        }   
         return view('stock.infoStock', compact('delivery','stationAddress' ));

} }
  
    