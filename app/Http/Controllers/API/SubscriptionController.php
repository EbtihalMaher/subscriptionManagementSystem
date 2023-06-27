<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ActivationCode;
use App\Models\OnlinePayment;
use App\Models\Subscription;
use App\Models\Client;
use App\Models\Package;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class SubscriptionController extends Controller
{

    public function decreaseLimit(Request $request)
    {
        $client = Client::ByEnterpriseID()->findOrFail($request->client_id);

        $clientProfile = $client->profile;

        $currentSubscription = $client->subscriptions()->where('id', $clientProfile->current_subscription_id)->first();

        if ($clientProfile && $currentSubscription && $currentSubscription->limit !== null) {
            $discount = $request->input('discount');
            $limit = $clientProfile->limit - $discount;
            $currentSubscription->limit = $currentSubscription->limit - $discount;

            if ($limit < 0) {
                $limit = 0;
            }

            $clientProfile->limit = $limit;
            $clientProfile->save();
            $currentSubscription->save();

            return response()->json(['message' => 'Limit decreased successfully.', 'client' => $client]);
        } else {
            return response()->json(['message' => 'Client or current subscription not found.'], 404);
        }
    }


    // public function decreaseLimit(Request $request, $subscription_id)
    // {
    //     $subscription = Subscription::ByEnterpriseID()->findOrFail($subscription_id);

    //     if ($subscription->limit !== null) {
    //         $discount = $request->input('discount');
    //         $subscription->limit = $subscription->limit - $discount;
    //         $subscription->save();
    //     }

    //     return response()->json(['subscription' => $subscription]);
    // }


    public function store(Request $request)
    {
        //Validating the request data
        $validator = Validator::make($request->all(), [
            'client_id' => 'required',
            'package_id' => 'required',
            'transaction_number' => 'nullable',
            'activation_code' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], \Symfony\Component\HttpFoundation\Response::HTTP_BAD_REQUEST);
        }

        $client = Client::query()->find($request->client_id);

        //Handling the package and duration
        $package = Package::findOrFail($request->package_id);
        if ($package->is_unlimited()) {
            $limit = $package->limit;
        } else {
            $limit = null;
        }

        $duration = $package->duration;
        $durationUnit = $package->duration_unit;

        //Handling the start and end dates of the new subscription
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
                return response()->json(['message' => 'Unsupported duration unit'], \Symfony\Component\HttpFoundation\Response::HTTP_BAD_REQUEST);
        }

        //Handling payment details
        $onlinePaymentId = null;
        $transaction_number = $request->input('transaction_number');
        $activationCode = $request->input('activation_code');
        $paidAmount = $package->price;

        if (!empty($transaction_number)) {
            $onlinePayment = OnlinePayment::where('transaction_number', $transaction_number)->first();

            if (!$onlinePayment) {
                return response()->json(['message' => 'Invalid transaction number'], Response::HTTP_BAD_REQUEST);
            }

            $onlinePaymentId = $onlinePayment->id;
            $paidAmount = $onlinePayment->amount;


        } elseif (!empty($activationCode)) {
            $activation = ActivationCode::where('number', $activationCode)
                ->where('package_id', $request->package_id)
                ->first();

            if (!$activation) {
                return response()->json(['message' => 'Invalid activation code'], Response::HTTP_BAD_REQUEST);
            }

            $today = Carbon::now()->toDateString();
            $start_date = $activation->start_date;
            $end_date = $activation->end_date;

            if ($start_date >= $today || $end_date <= $today) {
                return response()->json(['message' => 'Activation code is not valid'], Response::HTTP_BAD_REQUEST);
            }

            $paidAmount = $activation->price;

        }

        $subscriptionMethod = !empty($activationCode) ? 'activation_code' : 'online';

        //Creating the subscription
        $subscription = Subscription::create([
            'client_id' => $client->id,
            'package_id' => $request->package_id,
            'enterprise_id' => $client->enterprise_id,
            'online_payment_id' => $onlinePaymentId,
            'subscription_method' => $subscriptionMethod,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'limit' => $limit,
            'paid_amount' => $paidAmount,
        ]);

        return response()->json(['subscription' => $subscription], 201);
    }
}
