<?php

namespace App\Http\Controllers;

use App\Models\ActivationCode;
use App\Models\ActivationCodeGroup;
use App\Models\Package;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use DateTime;
use Illuminate\Support\Str;

class ActivationCodeGroupController extends Controller
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
    public function index()
    {
        $activationCodeGroups = ActivationCodeGroup::with('package')->withTrashed()->get();
        return response()->view('cms.activation_codes_groups.index', ['activationCodeGroups' => $activationCodeGroups]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $packages = Package::ByEnterprise()->get();
        return response()->view('cms.activation_codes_groups.create', ['packages' => $packages]);
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
            'start_date' => 'date_format:d-M-Y',
            'start_date' => 'date_format:d-M-Y',
            'price' => 'required|numeric',


        ]);

        if (!$validator->fails()) {
            $activationCodeGroup = new ActivationCodeGroup();
            $activationCodeGroup->package_id = $request->input('package_id');
            $activationCodeGroup->group_name = $request->input('group_name');
            $activationCodeGroup->count = $request->input('count');

            $start_date_str = $request->input('start_date');
            $start_date = DateTime::createFromFormat('d-M-Y', $start_date_str);

            if ($start_date !== false) {
                $start_date_mysql = $start_date->format('Y-m-d H:i:s');
                $activationCodeGroup->start_date = $start_date_mysql;
            } else {
                // Handle invalid date string
            }

            $expire_date_str = $request->input('expire_date');
            $expire_date = DateTime::createFromFormat('d-M-Y', $expire_date_str);

            if ($expire_date !== false) {
                $expire_date_mysql = $expire_date->format('Y-m-d H:i:s');
                $activationCodeGroup->expire_date = $expire_date_mysql;
            } else {
                // Handle invalid date string
            }
            
            $activationCodeGroup->price = $request->input('price');
            $activationCodeGroup->enterprise_id = auth()->user()->enterprise_id;
            $isSaved = $activationCodeGroup->save();

            if ($isSaved) {
                $count = $request->count;
                $codes = [];
                for ($i = 0 ; $i < $count ; $i++) {
                    $codes[] = [
                        'group_id'  => $activationCodeGroup->id,
                        'number'    => Str::random(6),
                    ];
                }
                ActivationCode::query()->insert($codes);
            }

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
        $isDeleted = $activationCodeGroup->delete();
        return response()->json(
            ['message' => $isDeleted ? 'Deleted successfully' : 'Delete failed'],
            $isDeleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
        );
    }
}

