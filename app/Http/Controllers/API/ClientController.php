<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:clients',
            'phone_number' => 'required|string',
            'enterprise_id' => 'required|exists:enterprises,id',
        ]);

        // $client = Client::where('email', $validatedData['email'])->first();

        // if ($client) {
        //     return response()->json(['message' => 'Client with this email already exists'], 409);
        // }

    /****************************************************** */
        // $existingClient = Client::where('email', $validatedData['email'])->first();

        // if ($existingClient) {
        //     return response()->json(['message' => 'Client with this email already exists'], Response::HTTP_CONFLICT);
        // }

        // $client = new Client($validatedData);
        // $client->save();

        // return response()->json($client, Response::HTTP_CREATED);

    /****************************************************** */
        
        // $client = Client::where('email', $validatedData['email'])->newOrFirst($validatedData);
        // $client->save();

        // return response()->json(['client' => $client], 201);

    /****************************************************** */

        $client = Client::updateOrCreate(['email' => $validatedData['email']], $validatedData);

        return response()->json($client, Response::HTTP_CREATED);

         // $client = Client::create($validatedData);
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        //
    }
}
