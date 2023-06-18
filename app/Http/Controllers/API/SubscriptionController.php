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

    public function decreaseLimit(Request $request, $client_id)
    {
        $client = Client::ByEnterpriseID()->findOrFail($client_id);

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
}
