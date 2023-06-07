<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Package;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Subscription;
use App\Models\OnlinePayment;
// use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response;

class ClientController extends Controller
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
        $client = Client::where('email', $request->email)->first();

        if (!$client) {
            $client = Client::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'enterprise_id' => $request->enterprise_id,
            ]);
        }

        $package = Package::findOrFail($request->package_id);
        $duration = $package->duration;
        $durationUnit = $package->duration_unit;

        $lastSubscription = Subscription::where('client_id', $client->id)
            ->orderBy('end_date', 'desc')
            ->first();

        if ($lastSubscription && Carbon::parse($lastSubscription->end_date)->isFuture()) {
            $startDate = Carbon::parse($lastSubscription->end_date)->addDay();
        } else {
            $startDate = Carbon::now();
        }

        $endDate = $startDate->copy();
        switch ($durationUnit) {
            case 'd':
                $endDate->addDays($duration);
                break;
            case 'm':
                $endDate->addMonths($duration);
                break;
            case 'y':
                $endDate->addYears($duration);
                break;
            default:
                return response()->json(['message' => 'Unsupported duration unit'], Response::HTTP_BAD_REQUEST);
        }

        $onlinePaymentId = null;
        $transaction_number = $request->input('transaction_number');
        if (!empty($transaction_number)) {
            $onlinePayment = OnlinePayment::where('transaction_number', $transaction_number)->first();
            if (!$onlinePayment) {
                return response()->json(['message' => 'Invalid transaction number'], Response::HTTP_BAD_REQUEST);
            }
            $onlinePaymentId = $onlinePayment->id;
        }

        $subscription = Subscription::create([
            'client_id' => $client->id,
            'package_id' => $request->package_id,
            'enterprise_id' => $client->enterprise_id,
            'online_payment_id' => $onlinePaymentId,
            'subscription_method' => 'online',
            'start_date' => $startDate,
            'end_date' => $endDate,
            'limit' => $package->limit,
        ]);

        return response()->json(['subscription' => $subscription], 201);
    }


    public function show(Client $client)
    {
        //
    }

    
    public function edit(Client $client)
    {
        //
    }

   
    public function update(Request $request, Client $client)
    {
        //
    }

    public function destroy(Client $client)
    {
        //
    }
}
