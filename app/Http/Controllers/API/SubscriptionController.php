<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\Client;
use App\Models\Package;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Carbon\Carbon;

class SubscriptionController extends Controller
{
  
    public function index()
    {
        //
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {

        // $validatedData = $request->validate([
        //     'client_id' => 'required|exists:clients,id',
        //     'package_id' => 'required|exists:packages,id',
        //     // 'enterprise_id' => 'required|exists:enterprises,id',

            
        //     // 'start_date' => 'required|date',
        //     // 'end_date' => 'required|date',
        //     // 'limit' => 'nullable|integer',
        // ]);

        // // dd("ss");

       
        // // Fetch the client and associated enterprise
        // $client = Client::findOrFail($validatedData['client_id']);
        // $enterpriseId = $client->enterprise->id;

        // // Fetch the package and its duration and limit
        // $package = Package::findOrFail($validatedData['package_id']);
        // $duration = $package->duration;
        // $durationUnit = $package->duration_unit;
        // $limit = $package->limit;

        // // Calculate the start date from the current date
        // $startDate = Carbon::now();

        // // Calculate the end date based on the start date and package duration
        // $endDate = $startDate->copy();
        // switch ($durationUnit) {
        //     case 'd':
        //         $endDate->addDays($duration);
        //         break;
        //     case 'm':
        //         $endDate->addMonths($duration);
        //         break;
        //     case 'y':
        //         $endDate->addYears($duration);
        //         break;
        //     default:
        //         // Handle unsupported duration units
        //         return response()->json(['message' => 'Unsupported duration unit'], Response::HTTP_BAD_REQUEST);
        // }

        // // Create the subscription
        // $subscription = new Subscription();
        // $subscription->client_id = $validatedData['client_id'];
        // $subscription->package_id = $validatedData['package_id'];
        // $subscription->enterprise_id = $enterpriseId;
        // $subscription->start_date = $startDate;
        // $subscription->end_date = $endDate;
        // $subscription->limit = $limit;
        // $subscription->save();

        // return response()->json($subscription, Response::HTTP_CREATED);
    }

    

    
   
    public function show(Subscription $subscription)
    {
        //
    }

   
    public function edit(Subscription $subscription)
    {
        //
    }

    public function update(Request $request, Subscription $subscription)
    {
        //
    }
    public function destroy(Subscription $subscription)
    {
        //
    }
}
