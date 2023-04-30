<?php

namespace App\Http\Controllers;

use App\Models\ActivationCodeGroup;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ActivationCodeGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activationCodeGroups = ActivationCodeGroup::with('package')->get();
        return response()->view('cms.activation_codes_groups.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {


        return response()->view('cms.activation_codes_groups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator($request->all(), [
            'package_id' => 'required|numeric|exists:packages,id',
            'group_name' => 'required|string',
            'count' => 'required|numeric',
            'start_date' => 'date',
            'start_date' => 'date',
            'price' => 'required|numeric',


        ]);

        if (!$validator->fails()) {
            $activationCodeGroup = new ActivationCodeGroup();
            $activationCodeGroup->package_id = $request->input('package_id');
            $activationCodeGroup->group_name = $request->input('group_name');
            $activationCodeGroup->count = $request->input('count');
            $activationCodeGroup->start_date = $request->input('start_date');
            $activationCodeGroup->expire_date = $request->input('expire_date');
            $activationCodeGroup->price = $request->input('price');
            $isSaved = $activationCodeGroup->save();
            return response()->json(
                ['message' => $isSaved ? 'Saved successfully' : 'Save failed!'],
                $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST
            );
        } else {
            return response()->json(
                ['message' => $validator->getMessageBag()->first()],
                Response::HTTP_BAD_REQUEST
            );
        }
    }
 

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ActivationCodeGroup  $activationCodeGroup
     * @return \Illuminate\Http\Response
     */
    public function show(ActivationCodeGroup $activationCodeGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ActivationCodeGroup  $activationCodeGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(ActivationCodeGroup $activationCodeGroup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ActivationCodeGroup  $activationCodeGroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ActivationCodeGroup $activationCodeGroup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ActivationCodeGroup  $activationCodeGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(ActivationCodeGroup $activationCodeGroup)
    {
        //
    }
}

