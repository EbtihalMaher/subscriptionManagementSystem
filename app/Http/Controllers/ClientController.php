<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;


class ClientController extends Controller
{
    public function index () {
        $clients = Client::byEnterpriseID()->with('subscriptions', 'profile')->get();

        return response()->view('cms.clients.index', ['clients' => $clients]);
    }

    public function showProfile ($clientId)
    {

    }

    public function showSubscriptions ($clientId)
    {

    }
}
