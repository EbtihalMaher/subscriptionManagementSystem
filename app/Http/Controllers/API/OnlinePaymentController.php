<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\OnlinePayment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OnlinePaymentController extends Controller
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
        // Retrieve the client_id, package_id, and payment_method from the request
        $client_id = $request->input('client_id');
        $package_id = $request->input('package_id');
        $payment_method = $request->input('payment_method');

        // Get the price from the Package model using the package_id
        $package = Package::findOrFail($package_id);
        $amount = $package->price;

        // Generate a random 12-digit transaction number
        $transaction_number = Str::random(12);

        // Create a new OnlinePayment instance
        $onlinePayment = OnlinePayment::create([
            'client_id' => $client_id,
            'amount' => $amount,
            'transaction_number' => $transaction_number,
            'payment_method' => $payment_method,
        ]);

        // Return the response
        return response()->json(['online_payment' => $onlinePayment], 201);
    }

    

    public function show($id)
    {
        //
    }
    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
