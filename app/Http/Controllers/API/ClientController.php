<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ActivationCode;
use App\Models\Client;
use App\Models\Package;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Subscription;
use App\Models\OnlinePayment;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use App\Models\ClientProfile;
use Illuminate\Support\Facades\DB;


class ClientController extends Controller
{

    public function index()
    {
        $clients = Client::byEnterpriseID()->with('subscriptions', 'profile')->get();
        $packageIds = $clients->pluck('profile.package_id')->toArray();
        $packages = Package::whereIn('id', $packageIds)->pluck('name', 'id')->toArray();

        foreach ($clients as $client) {
            $profilePackageId = $client->profile->package_id;
            $package = Package::find($profilePackageId);
            $client->profile->package_name = $package->name ?? null;
            $client->profile->package_limit = $package->limit ?? null;
        }

         return response()->json(['clients' => $clients]);
    }


    public function show($id)
    {

        $client = Client::ByEnterpriseID()->with('subscriptions', 'profile')->findOrFail($id);
        return response()->json(['client' => $client]);

    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], \Symfony\Component\HttpFoundation\Response::HTTP_BAD_REQUEST);
        }

        $client = Client::query()->firstOrCreate(
            [
                'name'              => $request->name,
                'email'             => $request->email,
                'phone_number'      => $request->phone_number,
                'enterprise_id'     => session('enterprise_id'),
            ]
        );

        $clientProfile = ClientProfile::create([
            'client_id'                 => $client->id,
            'current_subscription_id'   => null,
            'start_date'                => null,
            'end_date'                  => null,
            'package_id'                => null,
            'limit'                     => null,
        ]);

        return response()->json(['client' => $client]);

    }





    public function refreshProfile($clientId){
        $client = Client::query()->find($clientId);
        $clientProfile = $client->profile;
        if (!$clientProfile) {
            $clientProfile = ClientProfile::create([
                'client_id' => $client->id,
                'current_subscription_id' => null,
                'start_date' => null,
                'end_date' => null,
                'package_id' => null,
                'limit' => null,
            ]);
        }

        if ($clientProfile) {
            $latestSubscription = $client->subscriptions()
                ->where('end_date', '>=', Carbon::now())->orderBy('start_date', 'desc')->first();

            if ($latestSubscription) {
                $clientProfile->current_subscription_id = $latestSubscription->id;
                $clientProfile->start_date = $latestSubscription->start_date;
                $clientProfile->end_date = $latestSubscription->end_date;
                $clientProfile->package_id = $latestSubscription->package_id;
                $clientProfile->limit = $latestSubscription->limit;
            } else {
                $clientProfile->current_subscription_id = null;
                $clientProfile->start_date = null;
                $clientProfile->end_date = null;
                $clientProfile->package_id = null;
                $clientProfile->limit = null;
            }

            $clientProfile->save();

            $client = $client->refresh(); // Refresh the client model to get updated profile

            return response()->json(['message' => 'Client profile updated successfully.', 'client' => $client]);
        } else {
            return response()->json(['message' => 'Client profile not found.'], 404);
        }
    }


}
