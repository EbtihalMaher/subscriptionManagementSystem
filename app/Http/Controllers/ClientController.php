<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Models\ClientProfile;




class ClientController extends Controller
{
    public function index () {
        $clients = Client::byEnterpriseID()->with('subscriptions', 'profile')->get();

        return response()->view('cms.clients.index', ['clients' => $clients]);
    }

    public function showProfile ($clientId)
    {
      $client = Client::findOrFail($clientId);
      $profile = ClientProfile::where('client_id', $clientId)->first();
  
      return view('cms.clients.profile', ['client' => $client, 'profile' => $profile]);
    }

    public function showSubscriptions ($clientId)
    {
    $client = Client::findOrFail($clientId);

    $subscriptions = Subscription::where('client_id', $clientId)->get();

    return view('cms.clients.subscriptions', [ 'client' => $client,'subscriptions' => $subscriptions ]);
    }
}
