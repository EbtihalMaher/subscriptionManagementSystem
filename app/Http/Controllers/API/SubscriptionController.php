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
    public function decreaseLimit(Request $request, $subscription_id)
    {
        $subscription = Subscription::findOrFail($subscription_id);

        if ($subscription->limit !== null) {
            $discount = $request->input('discount');
            $subscription->limit = $subscription->limit - $discount;
            $subscription->save();
        }

        return response()->json(['subscription' => $subscription]);
    }
}
