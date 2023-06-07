<?php

namespace App\Http\Controllers;

use App\Models\ActivationCode;
use App\Models\ActivationCodeGroup;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ActivationCodeController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:Read-Users', ['only' => ['index', 'show']]);
        $this->middleware('permission:Create-User', ['only' => ['create', 'store']]);
        $this->middleware('permission:Delete-User', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $activationCodes = ActivationCode::with('activationCodeGroup')->where('group_id', $request->query('group_id'))->get();
        return response()->view('cms.activation_codes.index',  ['activationCodes' => $activationCodes]);
        // $activationCodes = ActivationCode::with('activationCodeGroup')->get();
        // return response()->view('cms.activation_codes.index', ['activationCodes' => $activationCodes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function create()
    {
        $activationCodeGroups = ActivationCodeGroup::ByEnterprise()->get();
        return response()->view('cms.activation_codes.create', ['activationCodeGroups' => $activationCodeGroups]);
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
            'group_id' => 'required|numeric|exists:activation_code_groups,id',
            'number' => 'required|numeric',


        ]);

        if (!$validator->fails()) {
            $activationCode = new ActivationCode();
            $activationCode->group_id = $request->input('group_id');
            $activationCode->number = $request->input('number');
            $activationCode->enterprise_id = auth()->user()->enterprise_id;
            $isSaved = $activationCode->save();
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
     * @param  \App\Models\ActivationCode  $activationCode
     * @return \Illuminate\Http\Response
     */
    public function show(ActivationCode $activationCode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ActivationCode  $activationCode
     * @return \Illuminate\Http\Response
     */
    public function edit(ActivationCode $activationCode)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ActivationCode  $activationCode
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ActivationCode $activationCode)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ActivationCode  $activationCode
     * @return \Illuminate\Http\Response
     */
    public function destroy(ActivationCode $activationCode)
    {
        // $isDeleted = $activationCode->delete();
        // return response()->json(
        //     ['message' => $isDeleted ? 'Deleted successfully' : 'Delete failed'],
        //     $isDeleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
        // );
    }
}
